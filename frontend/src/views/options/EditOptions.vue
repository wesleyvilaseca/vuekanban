<template>
  <div>
    <PageTitle page="Adicionar informação" :pages="pages"/>

    <div class="row">

      <!-- Edita as informações -->
      <div class="col-md-3">
        <FormOptions
            title="Alterar a informação"
            description="Preencha os campos a baixo"
            :item="option"
            @processaFormulario="alterarOption($event)"
        />
      </div>

      <div class="col-md-9">
        <!-- Adicionar valores -->
        <div class="card">
          <div class="card-body">
            <h4 class="mt-0 mb-3 header-title">Adicione valores</h4>

            <div class="form-group">
              <label>Valor para a informação</label>
              <input type="text" class="form-control" placeholder="Ex: Branco" v-model="optionValue.name" />
              <span v-if="valida > 0 && optionValue.name.length === 0" class="valida">Preecha esse campo.</span>
            </div>

            <div class="form-group mt-4">
              <button class="btn btn-primary" @click="adicionarValorOption()">
                Adicionar
              </button>
            </div>
          </div>
        </div>

        <!-- Lista os valores -->
        <TableList
            title="Valores cadastrados"
            :campos="campos"
            :itens="getListValue()"
            :acoes="['delete']"
            @deletar="deletarValor($event)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import PageTitle from "@/components/template/PageTitle";
import {mapActions, mapState} from "vuex";
import FormOptions from "@/components/options/FormOptions";
import TableList from "@/components/template/TableList";

export default {
  name: "EditOptions",
  components: {TableList, FormOptions, PageTitle},
  data: () => ({
    pages: [
      {
        name: "Início",
        link: "/"
      },
      {
        name: "Informações",
        link: "/informacoes"
      }
    ],
    id: "",
    campos: [
      { text: 'ID', field: 'id' },
      { text: 'Valor', field: 'name' }
    ],
    option: {},
    optionValue: {name: ""},
    valida: 0
  }),
  computed: {
    ...mapState("options", ["listOptionsValue"])
  },
  methods: {
    ...mapActions("options", ["getOptionId", "getValueOption", "updateOption", "deleteValueOption", "insertOptionValue"]),

    getListValue() {
      var id = this.id;
      return this.listOptionsValue.filter(data => data.option_id == id)
    },

    alterarOption(obj){
      obj.id = this.id

      var form = new FormData();
      form.set("title", obj.title);
      form.set("description", obj.description);
      form.set("type", "unique");

      this.updateOption({obj, form})
    },

    adicionarValorOption() {
      this.valida = 1;

      if(this.optionValue.name === "" || this.optionValue.name === null)
        return false;

      // Repassa o obj para form obj.
      let form = new FormData();
      form.set("name", this.optionValue.name);
      form.set("option_id", this.id);

      this.insertOptionValue(form)
      this.valida = 0;
      this.optionValue.name = ""

      setTimeout(() => {
        this.buscaValores()
      }, 500)
    },

    deletarValor(obj) {
      // Verifica se realmente deve deletar
      this.$swal.fire({
        title: 'Deletar Valor',
        text: `Deseja realmente deletar o valor?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Sim, pode deletar.',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteValueOption(obj)
              .then(() => {
                this.buscaValores()
              })
        }
      })
    }
  },
  created() {
    this.id = this.parametros = this.$route.params.id

    // Busca o produto
    setTimeout(() => {
      this.getOptionId(this.id)
          .then((result) => {
            let item = result[0]
            this.option = item
          })
    }, 1500)
  }
}
</script>

<style scoped>

</style>