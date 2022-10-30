<template>
  <div>
    <PageTitle page="Alterar produto" :pages="pages" />

    <!-- Informações do produto -->
    <div class="row">
      <div class="col-md-12">
        <FormProducts
          :title="`Alterar o produto ${produto.title} `"
          description="Preencha os campos a baixo"
          :item="produto"
          @processaFormulario="salvaProduto($event)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import PageTitle from "@/components/template/PageTitle";
import FormProducts from "@/components/products/FormProducts";
import { mapActions } from "vuex";

export default {
  name: "EditProdutoView",
  components: { FormProducts, PageTitle },
  data: () => ({
    pages: [
      {
        name: "Início",
        link: "/",
      },
      {
        name: "Produtos",
        link: "/produtos",
      },
    ],
    parametros: {},
    produto: {
      id: 0,
      title: "",
      brand_id: "",
    },
  }),
  methods: {
    ...mapActions(["getProductId", "updateProduct"]),

    salvaProduto(item) {
      item.id = this.parametros.id;

      let form = new FormData();
      form.set("title", item.title);
      form.set("description", item.description);
      form.set("brand_id", item.brand_id);

      this.updateProduct({ obj: item, form })
        .then(() => {
          this.$router.push({ name: "produtos" });
        })
        .catch((err) => console.log("error", err));
    },
  },
  mounted() {
    // Recupera  os parametros
    this.parametros = this.$route.params;

    // Busca o produto
    setTimeout(() => {
      this.getProductId(this.parametros.id).then((result) => {
        let prod = result[0];
        prod.brand_id = prod.brand.id;
        this.produto = prod;
      });
    }, 1500);
  },
};
</script>