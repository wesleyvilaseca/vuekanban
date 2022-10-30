import { createRouter, createWebHistory } from 'vue-router'
import MarcasView from "@/views/brands/MarcasView";
import AddMarcaView from "@/views/brands/AddMarcaView";

import ProdutosView from "@/views/products/ProdutosView";
import AddProdutoView from "@/views/products/AddProdutoView";
import EditProdutoView from "@/views/products/EditProdutoView";
import OpcoesProdutoView from "@/views/products/OpcoesProdutoView";

import Options from "@/views/options/Options";
import AddOptions from "@/views/options/AddOptions";
import EditOptions from "@/views/options/EditOptions";
import kanbanView from "@/views/kanban/KanbanView";
import DashboardView from "@/views/dashboard/DashBoardView";
import LoginView from "@/views/auth/Login/LoginView";


import store from "@/store/index";

const routes = [
  {
    path: '/',
    name: 'login',
    meta: {
      title: "Login"
    },
    component: LoginView
  },
  {
    path: '/',
    component: () => import("../../src/AdminTheme.vue"),
    children: [
      {
        path: '/dashboard',
        name: 'dashboard',
        meta: {
          title: 'Dashboard'
        },
        component: DashboardView
      },
      {
        path: '/kanban',
        name: 'kanban',
        meta: {
          title: 'Kanban'
        },
        component: kanbanView
      },
    ]
  },
  // Marcas
  {
    path: '/marcas',
    name: 'marcas',
    meta: {
      title: "Marcas - " + store.state.nameSite
    },
    component: MarcasView
  },
  {
    path: '/marcas/adicionar',
    name: 'add_marcas',
    meta: {
      title: "Adicionar Marca - " + store.state.nameSite
    },
    component: AddMarcaView
  },

  // Produtos
  {
    path: '/produtos',
    name: 'produtos',
    meta: {
      title: "Produtos - " + store.state.nameSite
    },
    component: ProdutosView
  },
  {
    path: '/produtos/adicionar',
    name: 'add_produtos',
    meta: {
      title: "Adicionar Produto - " + store.state.nameSite
    },
    component: AddProdutoView,
  },
  {
    path: '/produto/:id',
    name: 'edit_produtos',
    meta: {
      title: "Editar Produto - " + store.state.nameSite
    },
    component: EditProdutoView,
  },

  {
    path: '/opcoes-produto/:id',
    name: 'product_options',
    meta: {
      title: "Opções do produto - " + store.state.nameSite
    },
    component: OpcoesProdutoView,
  },

  // Options
  {
    path: '/informacoes',
    name: 'informacoes',
    meta: {
      title: "Informações de produtos - " + store.state.nameSite
    },
    component: Options
  },
  {
    path: '/informacoes/adicionar',
    name: 'add_informacoes',
    meta: {
      title: "Adicionar Informações de Produtos - " + store.state.nameSite
    },
    component: AddOptions,
  },
  {
    path: '/informacoes/:id',
    name: 'edit_informacoes',
    meta: {
      title: "Editar Informação - " + store.state.nameSite
    },
    component: EditOptions,
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

/**
 * Responsável por formatar as metas tags */
router.beforeEach((to, from, next) => {
  // This goes through the matched routes from last to first, finding the closest route with a title.
  // e.g., if we have `/some/deep/nested/route` and `/some`, `/deep`, and `/nested` have titles,
  // `/nested`'s will be chosen.
  const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);

  // Find the nearest route element with meta tags.
  const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);

  const previousNearestWithMeta = from.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);

  // If a route with a title was found, set the document (page) title to that value.
  if (nearestWithTitle) {
    document.title = nearestWithTitle.meta.title;
  } else if (previousNearestWithMeta) {
    document.title = previousNearestWithMeta.meta.title;
  }

  // Remove any stale meta tags from the document using the key attribute we set below.
  Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el));

  // Skip rendering meta tags if there are none.
  if (!nearestWithMeta) return next();

  // Turn the meta tag definitions into actual elements in the head.
  nearestWithMeta.meta.metaTags.map(tagDef => {
    const tag = document.createElement('meta');

    Object.keys(tagDef).forEach(key => {
      tag.setAttribute(key, tagDef[key]);
    });

    // We use this to track which meta tags we create so we don't interfere with other ones.
    tag.setAttribute('data-vue-router-controlled', '');

    return tag;
  })
    // Add the meta tags to the document head.
    .forEach(tag => document.head.appendChild(tag));

  next();
});

export default router
