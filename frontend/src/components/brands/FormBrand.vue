<template>
  <div class="card">
    <div class="card-body">
      <h4 class="mt-0 header-title">{{ title }}</h4>
      <p class="sub-title" v-if="description !== ''" >{{ description }}</p>

      <div class="form-group">
        <label>Nome da marca</label>
        <input type="text" v-if="valida > 0 && marca.name.length === 0" class="form-control valida" placeholder="Ex: Samsung" v-model="marca.name" />
        <input type="text" v-else class="form-control" placeholder="Ex: Samsung" v-model="marca.name" />
        <span v-if="valida > 0 && marca.name.length === 0" class="valida">Preecha esse campo.</span>
      </div>

      <div class="form-group">
        <label>Descrição</label>
        <input type="text" v-if="valida > 0 && marca.description.length === 0" class="form-control valida" placeholder="Descrição sobre a marca" v-model="marca.description" />
        <input type="text" v-else class="form-control" placeholder="Descrição sobre a marca" v-model="marca.description" />
        <span v-if="valida > 0 && marca.description.length === 0" class="valida">Preecha esse campo.</span>
      </div>

      <div class="form-group">
        <button class="btn btn-primary" @click="processaForm()">
          Salvar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "FormBrand",
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
    marca: {
      name: "",
      description: ""
    }
  }),
  methods: {
    processaForm() {
      let vm = this;
      vm.valida = 1; // ativa a validação visual

      // Verifica se preencheu o titulo
      if(vm.marca.name === "" || vm.marca.name === null) {
        return false;
      }

      // Verifica se preencheu a descricao
      if(vm.marca.description === "" || vm.marca.description === null) {
        return false;
      }

      // Retorna o conteudo
      this.$emit("processaFormulario", vm.marca);
    }
  },
  updated() {
    if(this.item) {
      this.marca = this.item;
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