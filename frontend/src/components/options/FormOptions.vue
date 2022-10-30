<template>
  <div class="card">
    <div class="card-body">
      <h4 class="mt-0 header-title">{{ title }}</h4>
      <p class="sub-title" v-if="description.length" >{{ description }}</p>

      <div class="form-group">
        <label>Título da informação</label>
        <input type="text" v-if="valida > 0 && option.title.length === 0" class="form-control valida" placeholder="Ex: Cor" v-model="option.title" />
        <input type="text" v-else class="form-control" placeholder="Ex: Cor" v-model="option.title" />
        <span v-if="valida > 0 && option.title.length === 0" class="valida">Preecha esse campo.</span>
      </div>

      <div class="form-group">
        <label>Descrição</label>
        <input type="text" v-if="valida > 0 && option.description.length === 0"
               class="form-control valida" placeholder="Descrição sobre a informação" v-model="option.description" />
        <input type="text" v-else class="form-control" placeholder="Descrição sobre a informação" v-model="option.description" />
        <span v-if="valida > 0 && option.description.length === 0" class="valida">Preecha esse campo.</span>
      </div>

      <div class="form-group mt-4">
        <button class="btn btn-primary" @click="processaForm()">
          Salvar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "FormOptions",
  props: {
    title: {
      type: String,
      required: false,
      default: ""
    },
    description: {
      type: String,
      required: false,
      default: ""
    },
    item: {
      type: Object,
      required: false
    }
  },
  data: () => ({
    valida: 0,
    option: {
      title: "",
      description: ""
    }
  }),
  methods: {
    processaForm() {
      let vm = this;
      vm.valida = 1; // ativa a validação visual

      // Verifica se preencheu o titulo
      if(vm.option.title === "" || vm.option.title === null) {
        return false;
      }

      // Verifica se preencheu a descricao
      if(vm.option.description === "" || vm.option.description === null) {
        return false;
      }

      // Retorna o conteudo
      this.$emit("processaFormulario", vm.option);
    }
  },
  updated() {
    if(this.item) {
      this.option = this.item;
    }
  }
}
</script>

<style>
.form-control.valida{
  border-color: #f81909;
}
span.valida{
  color: #f81909;
  padding-top: 3px;
}
</style>