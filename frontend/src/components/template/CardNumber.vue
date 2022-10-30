<template>
  <div :class="classe">
    <div class="card">
      <div class="card-heading p-4">
        <div v-if="icon.length" class="mini-stat-icon float-right">
          <i :class="icon"></i>
        </div>
        <div>
          <h5 class="font-16">{{ title }}</h5>
        </div>
        <h3 class="mt-4">{{ total }}</h3>
        <p v-if="descricao.length" class="text-muted mt-2 mb-0">{{ descricao }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CardNumber",
  props: {
    // eslint-disable-next-line vue/require-prop-type-constructor
    classe: "",
    // eslint-disable-next-line vue/require-prop-type-constructor
    icon: "",
    // eslint-disable-next-line vue/require-prop-type-constructor
    title: "",
    // eslint-disable-next-line vue/require-prop-type-constructor
    total: "",
    // eslint-disable-next-line vue/require-prop-type-constructor
    descricao: ""
  }
}
</script>

<style scoped>

</style>