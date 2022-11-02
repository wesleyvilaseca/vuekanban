<template>
  <div class="container-fluid">
    <div class="contatiner d-flex justify-content-between">
      <h4>Projetos</h4>
      <button class="btn btn-sm btn-primary" @click="modal(true)">
        Adicionar
      </button>
    </div>

    <TableComponent
      v-if="projects"
      :data="projects"
      :config="config"
      :isEdit="true"
      :isDelet="true"
      :isAccess="true"
      :deletemethod="delet"
      :editmethod="edit"
      :accessmethod="access"
    />

    <Modal v-show="isModalVisible" title="Projeto" @close="modal(false)">
      <template v-slot:content> form </template>
    </Modal>
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import TableComponent from "@/components/widgets/TableComponent.vue";
import Modal from "@/components/template/Modal";

// import PaginateTable from "@/components/Widgets/PaginateTable.vue";

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: "Projects",
  components: { TableComponent, Modal /* PaginateTable */ },
  data: () => ({
    isModalVisible: false,
    config: [
      {
        key: "name",
        title: "Nome",
      },
    ],
  }),
  computed: {
    ...mapState({
      projects: (state) => state.projects.projects,
    }),
  },
  mounted() {
    this.getProjects().catch((err) => {
      this.Toast.fire("Ocorreu um erro ao listar os produtos.", "", "error");
      console.log("error", err);
    });
  },
  methods: {
    ...mapActions(["getProjects"]),
    edit(item) {
      console.log(item);
    },

    delet(item) {
      console.log(item);
    },

    access(item) {
      return this.$router.push({
        name: "kanban.project",
        params: { id: item.id },
      });
    },

    newProject() {},

    modal(open) {
      this.isModalVisible = open;
    },
  },
};
</script>