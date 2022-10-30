<template>
  <transition name="modal-fade">
    <div class="modalVue open">
      <div class="bs-example-modal-center show">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title mt-0">{{ title }}</h5>
              <button type="button" @click="close()" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <!-- Conteudo -->
            <div class="modal-body">
              <slot name="content">
                <p>Conteudo aqui...</p>
              </slot>
            </div>

            <!-- Footer -->
            <slot name="footer">
            </slot>

          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'Modal',
  props: {
    title: {
      type: String,
      required: false,
      default: ""
    }
  },
  methods: {
    close() {
      this.$emit('close');
    },
  },
};
</script>

<style scoped>
.modal-fade-enter,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity .5s ease;
}

/* The Modal (background) */
.modalVue {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 55!important; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgba(0,0,0,0.6); /* Black w/ opacity */
}

.modalVue.open{
  display: block;
}

/* Modal Content/Box */
.modalVue .modal-content {
  background-color: #222437;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #171717;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.modalVue .modal-content .close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.modalVue .modal-content .close:hover,
.modalVue .modal-content .close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.modalVue .modal-footer{padding: 10px 0px 0px !important;}
.modalVue .modal-body{padding: 10px 0px !important;}
.modalVue .modal-header{padding: 10px 0px !important;}
.modalVue .modal-header h5 {
  font-size: 1.1em;
  padding-top: 4px;
}

.card {
  padding-bottom: 0px !important;
  margin-bottom: 0px !important;
}

</style>