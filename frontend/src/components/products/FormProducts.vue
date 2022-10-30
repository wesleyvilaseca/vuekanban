<template>
  <div class="card">
    <div class="card-body">
      <h4 class="mt-0 header-title">{{ title }}</h4>
      <p class="sub-title" v-if="description.length">{{ description }}</p>

      <div class="form-group">
        <label>Título do produto</label>
        <input
          type="text"
          v-if="valida > 0 && produto.title.length === 0"
          class="form-control valida"
          placeholder="Ex: Celular"
          v-model="produto.title"
        />
        <input
          type="text"
          v-else
          class="form-control"
          placeholder="Ex: Celular"
          v-model="produto.title"
        />
        <span v-if="valida > 0 && produto.title.length === 0" class="valida"
          >Preecha esse campo.</span
        >
      </div>

      <div class="form-group">
        <label>Descrição</label>
        <input
          type="text"
          v-if="valida > 0 && produto.description.length === 0"
          class="form-control valida"
          placeholder="Descrição sobre o produto"
          v-model="produto.description"
        />
        <input
          type="text"
          v-else
          class="form-control"
          placeholder="Descrição sobre o produto"
          v-model="produto.description"
        />
        <span
          v-if="valida > 0 && produto.description.length === 0"
          class="valida"
          >Preecha esse campo.</span
        >
      </div>

      <div content="form-group">
        <label>Marca</label>
        <select class="form-control" v-model="produto.brand_id">
          <option v-for="brand in listBrands" :key="brand.id" :value="brand.id">
            {{ brand.name }}
          </option>
        </select>
        <span
          v-if="valida > 0 && produto.description.length === 0"
          class="valida"
          >Preecha esse campo.</span
        >
      </div>

      <div class="form-group mt-4">
        <button class="btn btn-primary" @click="processaForm()">Salvar</button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
  name: "FormProducts",
  props: {
    title: {
      type: String,
      required: false,
      default: "",
    },
    description: {
      type: String,
      required: false,
      default: "",
    },
    item: {
      type: Object,
      required: false,
    },
  },
  data: () => ({
    valida: 0,
    produto: {
      title: "",
      description: "",
      brand_id: "",
    },
  }),
  methods: {
    ...mapActions(["fetchBrands"]),

    processaForm() {
      let vm = this;
      vm.valida = 1; // ativa a validação visual

      // Verifica se preencheu o titulo
      if (vm.produto.title === "" || vm.produto.title === null) {
        return false;
      }

      // Verifica se preencheu a descricao
      if (vm.produto.description === "" || vm.produto.description === null) {
        return false;
      }

      // Verifica se preencheu a descricao
      if (vm.produto.brand_id === "" || vm.produto.brand_id === null) {
        return false;
      }

      // Retorna o conteudo
      this.$emit("processaFormulario", vm.produto);
    },
  },
  updated() {
    if (this.item) {
      this.produto = this.item;
    }
  },
  computed: {
    ...mapState({
      listBrands: (state) => state.brands.listBrands,
    }),
  },
};
</script>

<style>
.form-control.valida {
  border-color: #f81909;
}
span.valida {
  color: #f81909;
  padding-top: 3px;
}
</style>