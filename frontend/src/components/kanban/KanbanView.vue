<template>
  <div class="row flex-row flex-sm-nowrap py-3">
    <div class="col-sm-6 col-md-4 col-xl-3">
      <div class="card bg-light">
        <div class="card-body card-body-atv">
          <h2 class="lane-title">Backlog</h2>
          <Container
            group-name="trello"
            @drag-start="handleDragStart('backlog', $event)"
            @drop="handleDrop('backlog', $event)"
            :get-child-payload="getChildPayload"
          >
            <Draggable v-for="item in cards.backlog" :key="item.id">
              <CardComponent
                class="mt-2"
                :title="item.title"
                :subtitle="item.subtitle"
              >
                <template v-slot:body> {{ item.description }} </template>
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

    <div class="col-sm-6 col-md-4 col-xl-3">
      <div class="card bg-light">
        <div class="card-body card-body-atv">
          <h2 class="lane-title">Desenvolvimento</h2>
          <Container
            group-name="trello"
            @drag-start="handleDragStart('dev', $event)"
            @drop="handleDrop('dev', $event)"
            :get-child-payload="getChildPayload"
          >
            <Draggable v-for="item in cards.dev" :key="item.id">
              <CardComponent
                class="mt-2"
                :title="item.title"
                :subtitle="item.subtitle"
              >
                <template v-slot:body> {{ item.description }} </template>
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

    <div class="col-sm-6 col-md-4 col-xl-3">
      <div class="card bg-light">
        <div class="card-body card-body-atv">
          <h2 class="lane-title">Testes</h2>
          <Container
            group-name="trello"
            @drag-start="handleDragStart('testes', $event)"
            @drop="handleDrop('testes', $event)"
            :get-child-payload="getChildPayload"
          >
            <Draggable v-for="item in cards.testes" :key="item.id">
              <CardComponent
                class="mt-2"
                :title="item.title"
                :subtitle="item.subtitle"
              >
                <template v-slot:body> {{ item.description }} </template>
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

    <div class="col-sm-6 col-md-4 col-xl-3">
      <div class="card bg-light">
        <div class="card-body card-body-atv">
          <h2 class="lane-title">Concluído</h2>
          <Container
            group-name="trello"
            @drag-start="handleDragStart('concluido', $event)"
            @drop="handleDrop('concluido', $event)"
            :get-child-payload="getChildPayload"
          >
            <Draggable v-for="item in cards.concluido" :key="item.id">
              <CardComponent
                class="mt-2"
                :title="item.title"
                :subtitle="item.subtitle"
              >
                <template v-slot:body> {{ item.description }} </template>
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
    dragginCard: {
      lane: "",
      index: -1,
      cardData: {},
    },
    cards: {
      backlog: [
        {
          id: 1,
          title: "primeiro card",
          subtitle: "",
          description: "primeiro card desc",
        },
        {
          id: 2,
          title: "segundo card",
          subtitle: "",
          description: "segundo card desc",
        },
        {
          id: 3,
          title: "terceiro card",
          subtitle: "",
          description: "primeiro card desc",
        },
      ],
      dev: [
        {
          id: 4,
          title: "title quarto card",
          subtitle: "",
          description: "desc quarto card",
        },
        {
          id: 5,
          title: "title quinto card",
          subtitle: "",
          description: "desc quinto card",
        },
        {
          id: 6,
          title: "title sexto card",
          subtitle: "",
          description: "desc sexto card",
        },
      ],
      testes: [
        {
          id: 7,
          title: "title setimo card",
          subtitle: "",
          description: "desc setimo card",
        },
      ],
      concluido: [],
    },
    pages: [
      {
        name: "Início",
        link: "/",
      },
    ],
  }),
  methods: {
    ...mapActions(["getBoard"]),
    add() {
      if (this.newTask) {
        this.arrBacklog.push({ name: this.newTask });
        console.log(this.arrBacklog);
        this.newTask = "";
      }
    },

    handleDragStart(lane, dragResult) {
      const { payload, isSource } = dragResult;
      if (isSource) {
        this.dragginCard = {
          //lane é boar, exemplo backlog
          lane,
          index: payload.index,
          cardData: {
            //payload.index é o index do array
            ...this.cards[lane][payload.index],
          },
        };
      }
    },
    handleDrop(lane, dropResult) {
      const { removedIndex, addedIndex } = dropResult;
      if (lane === this.dragginCard.lane && removedIndex === addedIndex) {
        return;
      }

      if (removedIndex !== null) {
        //vai remover o index
        this.cards[lane].splice(removedIndex, 1);
      }

      if (addedIndex !== null) {
        this.cards[lane].splice(addedIndex, 0, this.dragginCard.cardData);
      }
    },

    getChildPayload(index) {
      return {
        index,
      };
    },
  },
  computed: {
    ...mapState({
      board: (state) => state.kanban.board,
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