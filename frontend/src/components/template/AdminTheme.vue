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
            <li class="menu-itens">
              <router-link :to="{ name: 'kanban' }" class="navbar-brand">
                <i class="fa fa-book"></i>
                <span>Projetos</span>
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
export default {
  name: "AdminTheme",
  data: () => ({
    menuOpen: true,
  }),
  methods: {
    toggleMenu() {
      if (this.menuOpen) this.menuOpen = false;
      else this.menuOpen = true;
    },
  },
};
</script>
