<template>
  <table class="table">
    <thead>
      <tr>
        <th v-for="(obj, index) in config" :key="index">{{ obj.title }}</th>
        <th v-if="isEdit || isDelet">#</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(row, index) in data" :key="index">
        <td v-for="(obj, ind) in config" :key="ind">{{ row[obj.key] }}</td>

        <td v-if="isEdit || isDelet">
          <template v-if="isEdit">
            <button
              class="btn btn-outline-primary btn-sm m-1"
              @click="edit(row)"
            >
              <i class="fas fa-pencil-alt"></i>
            </button>
          </template>
          <template v-if="isDelet">
            <button
              class="btn btn-outline-danger btn-sm m-1"
              @click="delet(row)"
            >
              <i class="fas fa-trash"></i>
            </button>
          </template>
          <template v-if="isAccess">
            <button
              class="btn btn-outline-info btn-sm m-1"
              @click="access(row)"
            >
              <i class="fas fa-eye"></i>
            </button>
          </template>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "TableComponent",
  props: {
    data: Object,
    config: Object,
    isEdit: Boolean,
    isDelet: Boolean,
    isAccess: Boolean,
    deletemethod: String,
    accessmethod: String,
    editmethod: String,
  },
  data() {
    return {};
  },
  methods: {
    edit(data) {
      this.editmethod(data);
    },
    delet(data) {
      this.deletemethod(data);
    },
    access(data) {
      this.accessmethod(data);
    },
  },
  created() {},
};
</script>