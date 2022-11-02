<template>
  <div>
    <div class="top">
      <button
        class="btn btn-sm btn-outline-info mr-2"
        @click.prevent="modalCard(true)"
      >
        Criar atividade
      </button>
      <button
        class="btn btn-sm btn-outline-dark"
        @click.prevent="modalBoard(true)"
      >
        Criar board
      </button>
    </div>

    <div class="row flex-row flex-sm-nowrap py-3">
      <div
        class="col-sm-6 col-md-4 col-xl-3"
        v-for="(board, index) in boards"
        :key="index"
      >
        <div class="card bg-light">
          <div class="text-right float">
            <span class="btn btn-sm btn-outline-danger rounded-circle">
              <i class="fas fa-trash"></i>
            </span>
          </div>
          <div class="card-body card-body-atv">
            <h2 class="lane-title">{{ board.title }}</h2>
            <Container
              group-name="trello"
              @drag-start="handleDragStart(index, $event)"
              @drop="handleDrop(index, $event)"
              :get-child-payload="getChildPayload"
            >
              <Draggable v-for="(card, index) in board.cards" :key="index">
                <CardComponent class="mt-2" :title="card.title" :subtitle="''">
                  <template v-slot:body> {{ card.description }} </template>
                  <template v-slot:footer>
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                  </template>
                </CardComponent>
              </Draggable>
            </Container>
          </div>
        </div>
      </div>
    </div>

    <Modal
      v-show="isModalCardVisible"
      title="Projeto"
      @close="modalCard(false)"
    >
      <template v-slot:content>
        <div class="form-group">
          <label>Título da atividade</label>
          <input
            type="text"
            class="form-control"
            v-model="card.title"
            required
          />
        </div>

        <div class="form-group">
          <label>Descrição</label>
          <input type="text" class="form-control" v-model="card.description" />
        </div>

        <div class="form-group mt-4">
          <button class="btn btn-primary" @click="processaFormAtividade()">
            <span v-if="isLoading"> Salvando... </span>
            <span v-else> Salvar </span>
          </button>
        </div>
      </template>
    </Modal>

    <Modal
      v-show="isModalBoardVisible"
      title="Projeto"
      @close="modalBoard(false)"
    >
      <template v-slot:content>
        <div class="form-group">
          <label>Título do board</label>
          <input
            type="text"
            class="form-control"
            v-model="boardForm.title"
            required
          />
        </div>

        <div class="form-group mt-4">
          <button class="btn btn-primary" @click="processaFormBoard()">
            <span v-if="isLoading"> Salvando... </span>
            <span v-else> Salvar </span>
          </button>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script>
// import PageTitle from "@/components/template/PageTitle";
import { Container, Draggable } from "vue3-smooth-dnd";
import { mapActions, mapState } from "vuex";
import CardComponent from "@/components/card/CardComponent";
import Modal from "@/components/template/Modal";

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: "KanbanView",
  components: { Container, CardComponent, Draggable, Modal },
  data: () => ({
    isModalCardVisible: false,
    isModalBoardVisible: false,
    projectId: "",
    boardForm: {
      title: "",
    },
    card: {
      id: "",
      board_id: "",
      index: "",
      title: "",
      description: "",
    },
    dragginCard: {
      lane: "",
      index: -1,
      cardData: {},
    },
  }),
  methods: {
    ...mapActions(["getBoard", "updateCard", "createAtv", "storeBoard"]),
    modalCard(open) {
      this.isModalCardVisible = open;
      if (!open) this.clearCard();
    },

    modalBoard(open) {
      this.isModalBoardVisible = open;
      if (!open) this.clearBoard();
    },

    processaFormBoard() {
      this.boardForm.project_id = this.projectId;
      this.storeBoard(this.boardForm).then((res) => {
        this.clearBoard();
        this.modalBoard(false);
      });
    },

    processaFormAtividade() {
      this.card.project_id = this.projectId;
      this.createAtv(this.card).then((res) => {
        this.clearCard();
        this.modalCard(false);
      });
    },
    add() {
      if (this.newTask) {
        this.arrBacklog.push({ name: this.newTask });
        console.log(this.arrBacklog);
        this.newTask = "";
      }
    },

    handleDragStart(index, dragResult) {
      const { payload, isSource } = dragResult;
      if (isSource) {
        this.dragginCard = {
          lane: index,
          index: payload.index,
          cardData: {
            //payload.index é o index do array
            ...this.boards[index].cards[payload.index],
          },
        };
      }
    },
    handleDrop(index, dropResult) {
      const { removedIndex, addedIndex } = dropResult;
      if (index === this.dragginCard.lane && removedIndex === addedIndex) {
        return;
      }

      if (removedIndex !== null) {
        this.boards[index].cards.splice(removedIndex, 1);
      }

      if (addedIndex !== null) {
        this.boards[index].cards.splice(
          addedIndex,
          0,
          this.dragginCard.cardData
        );

        this.card = {
          id: this.dragginCard.cardData.id,
          title: this.dragginCard.cardData.title,
          description: this.dragginCard.cardData.description,
          board_id: this.boards[index].id,
          index: addedIndex,
        };
      }

      if (this.card.id) {
        this.updateCard(this.card)
          .then(() => {
            console.log("ok");
            this.clearCard();
          })
          .catch((err) => console.log("error", err));
      }
    },
    clearCard() {
      this.card = {
        id: "",
        board_id: "",
        index: "",
        title: "",
        description: "",
      };
    },

    clearBoard() {
      this.boardForm = {
        title: "",
      };
    },

    getChildPayload(index) {
      return {
        index,
      };
    },
  },
  computed: {
    ...mapState({
      boards: (state) => state.kanban.board,
    }),
  },
  mounted() {
    console.log();
    this.projectId = this.$route.params.projectid;
    this.getBoard(this.projectId).catch((err) => {
      // this.Toast.fire("Ocorreu um erro ao listar os produtos.", "", "error");
      console.log("error", err);
    });
  },
};
</script>

<style scoped>
.placeholder {
  background: rgba(33, 33, 33, 0.08) !important;
  border-radius: 0.4rem !important;
  transform: scaleY(0.85);
  transform-origin: 0% 0%;
}

.card-body-atv {
  min-height: 500px;
}

.smooth-dnd-container {
  min-height: 500px !important;
}
</style>