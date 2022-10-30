<template>
  <div class="row flex-row flex-sm-nowrap py-3">
    <div
      class="col-sm-6 col-md-4 col-xl-3"
      v-for="(board, index) in boards"
      :key="index"
    >
      <div class="card bg-light">
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
</template>

<script>
// import PageTitle from "@/components/template/PageTitle";
import { Container, Draggable } from "vue3-smooth-dnd";
import { mapActions, mapState } from "vuex";
import CardComponent from "@/components/card/CardComponent";

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: "KanbanView",
  components: { Container, CardComponent, Draggable },
  data: () => ({
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
    ...mapActions(["getBoard", "updateCard"]),
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
    this.getBoard().catch((err) => {
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