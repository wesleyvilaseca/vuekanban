<template>
  <div
    id="side-menu"
    class="page-wrapper chiller-theme"
    :class="{ toggled: menuOpen }"
  >
    <a
      id="show-sidebar"
      class="btn btn-sm btn-dark side-btn"
      href="#"
      @click.prevent="toggleMenu()"
    >
      <i class="fas fa-bars"></i>
    </a>
    <nav id="sidebar" class="sidebar-wrapper">
      <div class="sidebar-content">
        <div class="sidebar-brand">
          <a href="#">VueKanban</a>
          <div id="close-sidebar" @click.prevent="toggleMenu()">
            <i class="fas fa-times"></i>
          </div>
        </div>

        <div class="sidebar-menu">
          <ul>
            <li v-for="(row, index) in projects" :key="index" class="menu-itens">
              <router-link :to="{ name: 'kanban.project', params: { projectid: row.id } }" class="navbar-brand">
                <i class="fa fa-book"></i>
                <span>{{ row.name }}</span>
              </router-link>
            </li>

            <li class="menu-itens">
              <router-link :to="{ name: 'kanban' }" class="navbar-brand">
                <span>Todos os projetos</span>
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="page-content">
      <div class="container-fluid">
        <slot name="body" />
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
  name: "AdminTheme",
  data: () => ({
    menuOpen: true,
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

    toggleMenu() {
      if (this.menuOpen) this.menuOpen = false;
      else this.menuOpen = true;
    },
  },
};
</script>
