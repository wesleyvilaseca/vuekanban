<template>
  <div>
    <PageTitle page="Adicionar informação" :pages="pages"/>

    <div class="row">
      <div class="col-md-12">
        <FormOptions
            title="Adicionar informação"
            description="Preencha os campos a baixo"
            :item="{}"
            @processaFormulario="salvarOptions($event)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import PageTitle from "@/components/template/PageTitle";
import FormOptions from "@/components/options/FormOptions";
import {mapActions} from "vuex";

export default {
  name: "AddOptions",
  components: {FormOptions, PageTitle},
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
  }),
  methods: {
    ...mapActions("options", ["insertOption"]),

    salvarOptions(obj) {
      // Repassa o obj para form obj.
      let form = new FormData();
      form.set("title", obj.title);
      form.set("description", obj.description);
      form.set("type", "unique");

      this.insertOption(form)
    }
  }
}
</script>
