<template>
  <PageTitle page="Adicionar produto" :pages="pages" />

  <div class="row">
    <div class="col-12">
      <FormProducts
        title="Adicione um produto"
        description="Preencha os campos a baixo"
        :item="{}"
        @processaFormulario="salvaProduto($event)"
      />
    </div>
  </div>
</template>

<script>
import PageTitle from "@/components/template/PageTitle";
import FormProducts from "@/components/products/FormProducts";
import { mapActions } from "vuex";

export default {
  name: "AddProdutoView",
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
  }),
  methods: {
    ...mapActions(["insertProduct"]),

    salvaProduto(item) {
      // Repassa o obj para form obj.
      let form = new FormData();
      form.set("title", item.title);
      form.set("description", item.description);
      form.set("brand_id", item.brand_id);

      this.insertProduct(form)
        .then(() => {
          this.$router.push({ name: "produtos" });
        })
        .catch((err) => console.log("error", err));
    },
  }
};
</script>

<style scoped>
</style>