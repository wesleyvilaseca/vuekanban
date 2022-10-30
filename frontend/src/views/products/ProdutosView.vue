<template>
  <PageTitle page="Produtos" :pages="pages" />

  <!-- Table -->
  <div class="row">
    <div class="col-xl-12">
      <TableList
        title="Produtos cadastrados"
        :campos="campos"
        :itens="products"
        :acoes="acoes"
        @editar="editar($event)"
        @deletar="deletar($event)"
        @options="options($event)"
      />
    </div>
  </div>
</template>

<script>
import PageTitle from "@/components/template/PageTitle";
import TableList from "@/components/template/TableList";
import { mapActions, mapState } from "vuex";

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: "Produtos",
  components: { TableList, PageTitle },
  data: () => ({
    pages: [
      {
        name: "Início",
        link: "/",
      },
    ],
    campos: [
      { text: "ID", field: "id" },
      { text: "Titulo", field: "title" },
      { text: "Descrição", field: "description" },
      { text: "Marca", field: "brand" },
    ],
    acoes: ["edit", "delete", "options"],
  }),
  mounted() {
    this.fetchProducts().catch((err) => {
      this.Toast.fire("Ocorreu um erro ao listar os produtos.", "", "error");
      console.log("error", err);
    });
  },
  methods: {
    ...mapActions(["deleteProducts", "fetchProducts"]),

    editar(i) {
      this.$router.push(`/produto/${i.id}`);
    },

    deletar(item) {
      // Verifica se realmente deve deletar
      this.$swal
        .fire({
          title: "Deletar Produto",
          text: `Deseja realmente deletar o produto ${item.title}?`,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Sim, pode deletar.",
          cancelButtonColor: "#d33",
          cancelButtonText: "Cancelar",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.deleteProducts(item)
          }
        });
    },

    options(i) {
      console.log(i);
        this.$router.push({name: 'product_options', params: { id: i.id }});
    }
  },
  computed: {
    ...mapState({
      products: (state) => state.products.listProducts,
    }),
  },
};
</script>

<style scoped>
</style>