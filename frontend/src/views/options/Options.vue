<template>
  <div>
    <PageTitle page="Informações de produto" :pages="pages"/>

    <!-- Table -->
    <div class="row">
      <div class="col-xl-12">
        <TableList
            title="Informações cadastradas"
            :campos="campos"
            :itens="listOptions"
            :acoes="acoes"
            @editar="editar($event)"
            @deletar="deletar($event)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import PageTitle from "@/components/template/PageTitle";
import TableList from "@/components/template/TableList";
import {mapActions, mapState} from "vuex";
export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: "Options",
  components: {TableList, PageTitle},
  data: () => ({
    pages: [
      {
        name: "Início",
        link: "/"
      }
    ],
    campos: [
      { text: 'ID', field: 'id' },
      { text: 'Titulo', field: 'title' },
      { text: 'Descrição', field: 'description' }
    ],
    acoes: ['edit', 'delete']
  }),
  computed: {
    ...mapState("options",["listOptions"])
  },
  methods: {
    ...mapActions("options", ["deleteOptions"]),

    editar(i) {
      this.$router.push(`/informacoes/${i.id}`);
    },

    deletar(item) {

      // Verifica se realmente deve deletar
      this.$swal.fire({
        title: 'Deletar Informação',
        text: `Deseja realmente deletar a informação ${item.title}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Sim, pode deletar.',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteOptions(item);
        }
      })
    }
  }
}
</script>

<style scoped>

</style>