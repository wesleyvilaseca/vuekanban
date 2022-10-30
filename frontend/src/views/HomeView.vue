<template>
  <PageTitle page="Início" pages="" />

  <!-- Cards -->
  <div class="row">
    <CardNumber
        title="Produtos"
        :total="totalProducts()"
        icon="mdi mdi-tag-multiple bg-success text-white"
        descricao="total de produtos"
        classe="col-sm-6"
      />

    <CardNumber
        title="Marcas"
        :total="totalBrands()"
        icon="mdi mdi-tag-multiple bg-info text-white"
        descricao="total de marcas"
        classe="col-sm-6"
      />
  </div>

  <!-- Table -->
  <div class="row">
    <div class="col-xl-12">
      <TableList
          title="Últimos Produtos"
          :campos="campos"
          :itens="produtos()"
          :acoes="acoes"
      />
    </div>

    <div class="col-md-12">
      <div class="text-center">
        <router-link to="/produtos" v-if="produtos().length" class="btn btn-purple">
          Todos os produtos
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import PageTitle from "@/components/template/PageTitle";
import CardNumber from "@/components/template/CardNumber";
import TableList from "@/components/template/TableList";
import { mapGetters } from "vuex";

export default {
  name: 'HomeView',
  components: {TableList, CardNumber, PageTitle},
  data: () => ({
    campos: [
      { text: 'ID', field: 'id' },
      { text: 'Titulo', field: 'title' },
      { text: 'Descrição', field: 'description' },
      { text: 'Marca', field: 'brand' }
    ],
    acoes: [] // Edit, delete
  }),
  methods: {
    ...mapGetters(["totalBrands", "totalProducts", "getNewsProducts"]),

    produtos() {
      let prod = this.getNewsProducts();

      if(prod) {
        return prod;
      }

      return {}
    }
  }
}
</script>
