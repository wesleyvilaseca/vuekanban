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
              <a href="#">
                <i class="fa fa-book"></i>
                <span>Documentation</span>
                <span class="badge badge-pill badge-primary">Beta</span>
              </a>
            </li>
            <li class="menu-itens">
              <a href="#">
                <i class="fa fa-calendar"></i>
                <span>Calendar</span>
              </a>
            </li>
            <li class="menu-itens">
              <a href="#">
                <i class="fa fa-folder"></i>
                <span>Examples</span>
              </a>
            </li>
          </ul>
        </div>
        
      </div>
    </nav>

    <main class="page-content">
      <div class="container-fluid">
        <!-- <h2>DashBoard</h2> -->
        <hr />
        <slot name="body" />
      </div>
    </main>
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
