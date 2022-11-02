<template>
  <div class="card m-b-30">
    <div class="card-body">
      <h4 v-if="title.length" class="mt-0 header-title mb-4">{{ title }}</h4>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th
                v-for="(label, labelIndex) in campos"
                :key="labelIndex"
                scope="col"
              >
                {{ label.text }}
              </th>
              <th v-if="acoes.length" scope="col"></th>
            </tr>
          </thead>
          <tbody v-if="itens.length">
            <tr v-for="(item, itemIndex) in itens" :key="itemIndex">
              <td v-for="(label, labelIndex) in campos" :key="labelIndex">
                <p>{{ item[label.field] }}</p>
              </td>
              <td v-if="acoes.length">
                <button
                  v-if="inArray('edit', acoes)"
                  class="btn-sm btn-info m-1"
                  title="Editar"
                  @click="editarDeletar('editar', item)"
                >
                  <i class="mdi mdi-square-edit-outline"></i>
                </button>

                <button
                  v-if="inArray('options', acoes)"
                  class="btn-sm btn-warning m-1"
                  title="Opções"
                  @click="editarDeletar('options', item)"
                >
                  <i class="mdi mdi-alert-decagram"></i>
                </button>

                <button
                  v-if="inArray('delete', acoes)"
                  class="btn-sm btn-danger m-1"
                  title="Deletar"
                  @click="editarDeletar('deletar', item)"
                >
                  <i class="mdi mdi-window-close"></i>
                </button>
              </td>
            </tr>
          </tbody>

          <tbody v-else>
            <tr>
              <td :colspan="campos.length">Nenhum registro encontrado.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TableList",
  props: ["title", "campos", "itens", "acoes"],
  methods: {
    inArray(needle, haystack) {
      var length = haystack.length;
      for (var i = 0; i < length; i++) {
        if (haystack[i] == needle) return true;
      }
      return false;
    },

    editarDeletar(acao, i) {
      this.$emit(acao, i);
    },
  },
};
</script>

<style scoped>
</style>