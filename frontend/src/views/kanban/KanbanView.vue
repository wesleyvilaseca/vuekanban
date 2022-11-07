<template>
  <div>
    <div class="top" style="margin-top: 6px; margin-bottom: 15px;">
      <div class="item">
        <h1 class="tituloGeral">{{ getProjectAtual().name }}</h1>
        <p class="descGeral">{{ getProjectAtual().description }}</p>
      </div>
      <div class="item" style="text-align: right">
        <button
            class="btnAtividade btn btn-sm btn-outline-info mr-2"
            @click.prevent="modalCard(true)"
        >
          Criar atividade
        </button>
        <button
            class="btnBoard btn btn-sm btn-outline-dark"
            @click.prevent="modalBoard(true)"
        >
          Criar board
        </button>
      </div>
    </div>

    <div class="row flex-row flex-sm-nowrap py-3">
      <div
        class="col-sm-6 col-md-4 col-xl-3"
        v-for="(board, index) in boards"
        :key="index"
      >
        <div class="card bg-light">
          <span v-if="index !== 0" @click="deletBoard(board)" class="btnDeleta btn btn-sm btn-outline-danger rounded-circle">
            <i class="fas fa-trash"></i>
          </span>

          <span @click="modalBoard(true, 'edit', board)" class="btnEdit btn btn-sm btn-outline-primary rounded-circle">
            <i class="fas fa-edit"></i>
          </span>
          <div class="card-body card-body-atv cardKan">
            <h2 class="lane-title tituloProjeto">{{ board.title }}</h2>
            <Container
              group-name="trello"
              @drag-start="handleDragStart(index, $event)"
              @drop="handleDrop(index, $event)"
              :get-child-payload="getChildPayload"
            >
              <Draggable v-for="(card, index) in board.cards" :key="index">
                <CardComponent class="mt-2" :title="card.title" :subtitle="''">
                  <template v-slot:body>
                    {{ card.description }}
                  </template>

                  <template v-slot:footer>
                    <span @click="deleteCardAction(card)" class="btnDeleta btn btn-sm btn-outline-danger rounded-circle">
                      <i class="fas fa-trash"></i>
                    </span>

                    <span @click="modalCard(true, 'edit', card)" class="btnEdit btn btn-sm btn-outline-primary rounded-circle">
                      <i class="fas fa-edit"></i>
                    </span>
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
import Swal from "sweetalert2";

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: "KanbanView",
  components: { Container, CardComponent, Draggable, Modal },
  data: () => ({
    isModalCardVisible: false,
    isModalBoardVisible: false,
    typeFormBoard: "add",
    typeFormCard: "add",
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
    ...mapActions(["getBoard", "updateCard", "createAtv", "storeBoard", "deleteBoard", "updateBoard", "deleteCard"]),

    getProjectAtual() {
      return this.projects.filter(item => item.id == this.$route.params.projectid)[0]
    },

    modalCard(open, type = "add", card = null) {
      this.typeFormCard = type;
      this.isModalCardVisible = open;

      if(card) this.card = card;
      if (!open) this.clearCard();
    },

    modalBoard(open, type = "add", board = null) {
      this.typeFormBoard = type;
      this.isModalBoardVisible = open;

      if(board) this.boardForm = board;
      if (!open) this.clearBoard();
    },

    // Adiciona ou edita um board
    processaFormBoard() {

      this.boardForm.project_id = this.projectId;

      // Verifica se não é edição
      if(this.typeFormBoard === "add") {
        this.storeBoard(this.boardForm).then((res) => {
          this.clearBoard();
          this.modalBoard(false);
        });
        return false;
      }

      // Edita
      this.updateBoard({form: {title: this.boardForm.title}, id: this.boardForm.id}).then((res) => {
        this.clearBoard();
        this.modalBoard(false);
        this.getBoard(this.projectId).catch((err) => {
          console.log("error", err);
        });
      });

    },

    processaFormAtividade() {
      this.card.project_id = this.projectId;

      // Verify create card
      if(this.typeFormCard === "add") {
        this.createAtv(this.card).then((res) => {
          this.clearCard();
          this.modalCard(false);
        });
        return false;
      }

      // Update
      this.updateCard({id: this.card.id, title: this.card.title, description: this.card.description, board_id: this.card.board_id})
          .then(() => {
            this.modalCard(false);
            this.clearCard();
          })
          .catch((err) => console.log("error", err));
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

    inicialeBord() {
      if(this.projectId === "" || this.projectId !== this.$route.params.projectid) {
        this.projectId = this.$route.params.projectid;
        console.log(this.projectId)
        this.getBoard(this.projectId).catch((err) => {
          // this.Toast.fire("Ocorreu um erro ao listar os produtos.", "", "error");
          console.log("error", err);
        });
      }
    },

    deletBoard(item) {

      // Verifica se deseja realmente deletar
      Swal.fire({
        title: `Caso você confirme, todo o Board ${item.name} vai ser apagado, tem certeza que deseja apagar?`,
        icon: "warning",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonColor: '#527c4e',
        denyButtonColor: '#434642',
        confirmButtonText: 'Sim, desejo',
        denyButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteBoard(item).then(() => {
            this.getBoard(this.projectId).catch((err) => {
              console.log("error", err);
            });
          });
        }
      })
    },

    deleteCardAction(item) {
      // Verifica se deseja realmente deletar
      Swal.fire({
        title: `Deseja realmente deletar a atividade?`,
        icon: "warning",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonColor: '#527c4e',
        denyButtonColor: '#434642',
        confirmButtonText: 'Sim, desejo',
        denyButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteCard(item).then(() => {
            this.getBoard(this.projectId).catch((err) => {
              console.log("error", err);
            });
          });
        }
      })
    }
  },
  computed: {
    ...mapState({
      boards: (state) => state.kanban.board,
      projects: (state) => state.projects.projects,
    }),
  },
  updated() {
    this.inicialeBord();
  },
  created() {
    this.inicialeBord();
  }
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