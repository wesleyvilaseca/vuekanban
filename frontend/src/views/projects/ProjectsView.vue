<template>
  <div class="container-fluid" style="margin-top: 22px;">
    <div class="row">
      <div class="col-md-5">
        <h4 class="tituloItem">Projetos</h4>
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
      </div>

      <div class="col-md-7">
        <div class="card">
          <div class="card-body">
            <h4 style="margin-top: 0px; padding-top: 0px;"
                class="tituloItem">
              Adicionar novo projeto
            </h4>

            <div class="form-group">
              <label>Título da atividade</label>
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
          </div>
        </div>
      </div>
    </div>


    <Modal v-show="isModalVisible" title="Projeto" @close="modal(false)">
      <template v-slot:content>

        <div class="form-group">
          <label>Título da atividade</label>
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
import {mapActions, mapState} from "vuex";
import TableComponent from "@/components/widgets/TableComponent.vue";
import Modal from "@/components/template/Modal";
import Swal from "sweetalert2";

// import PaginateTable from "@/components/Widgets/PaginateTable.vue";

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: "Projects",
  components: {TableComponent, Modal /* PaginateTable */},
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
    ...mapActions([
      "getProjects",
      "storeProject",
      "deleteProject",
      "updateProject",
    ]),

    modal(type) {
      this.isModalVisible = type;
    },

    edit(item) {
      this.modal(true);
      this.formData.name = item.name;
      this.formData.description = item.description;
      this.projectId = item.id;
    },

    delet(item) {

      // Verifica se deseja realmente deletar
      Swal.fire({
        title: `Caso você confirme, todo o projeto ${item.name} vai ser apagado, tem certeza que deseja apagar o projeto?`,
        icon: "warning",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonColor: '#527c4e',
        denyButtonColor: '#434642',
        confirmButtonText: 'Sim, desejo',
        denyButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteProject(item.id).then(() => {
            this.clearForm();
            // this.modal(false);
          });
        }
      })
    },

    access(item) {
      return this.$router.push({
        name: "kanban.project",
        params: {projectid: item.id},
      });
    },

    processaForm() {

      if (!this.projectId) {
        this.storeProject(this.formData).then((res) => {
          this.isModalVisible = false;
          this.clearForm();
        });
        return;
      }

      this.updateProject({form: this.formData, id: this.projectId}).then((res) => {
        this.isModalVisible = false;
        this.clearForm();
      });

      this.isModalVisible = open;
      if (!open) this.clearForm();
    },

    clearForm() {
      this.formData = {
        title: "",
        description: "",
      };
      this.projectId = "";
    },
  },
};
</script>