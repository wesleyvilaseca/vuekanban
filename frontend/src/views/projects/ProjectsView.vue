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
      <template v-slot:content>
        <div class="form-group">
          <label>Título da projeto</label>
          <input
            type="text"
            class="form-control"
            v-model="formData.name"
            required
          />
        </div>

        <div class="form-group">
          <label>Descrição</label>
          <input
            type="text"
            class="form-control"
            v-model="formData.description"
          />
        </div>

        <div class="form-group mt-4">
          <button class="btn btn-primary" @click="processaForm()">
            <span v-if="isLoading"> Salvando... </span>
            <span v-else> Salvar </span>
          </button>
        </div>
      </template>
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
    isLoading: false,
    isModalVisible: false,
    projectId: "",
    formData: {
      name: "",
      description: "",
    },
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
    ...mapActions(["getProjects", "storeProject", "deleteProject"]),
    edit(item) {
      console.log(item);
    },

    delet(item) {
      if (
        confirm(
          `Caso você confirme, todo o projeto ${item.name} vai ser apagado, tem certeza que deseja apagar o projeto?`
        )
      ) {
        this.deleteProject(item.id);
      }
    },

    access(item) {
      return this.$router.push({
        name: "kanban.project",
        params: { id: item.id },
      });
    },

    processaForm() {
      this.storeProject(this.formData).then((res) => {
        this.isModalVisible = false;
      });
    },

    modal(open) {
      this.isModalVisible = open;
    },

    clearForm() {
      this.formData = {
        id: "",
        title: "",
        description: "",
      };
    },
  },
};
</script>