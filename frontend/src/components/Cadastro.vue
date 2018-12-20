<template>
  <div class="layout-padding modal-content-page shadow-1">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <form autocomplete="off">
          <div class="row gutter-sm">
            <div class="col-xs-12 col-sm-12 col-md-3">
              <q-field
                :error="$v.form.nome.$error"
                error-label="Nome da pessoa é obrigatório"
                helper="Campo obrigatório"
                >
                <q-input
                  v-model="form.nome"
                  class="no-margin"
                  id="cnpj"
                  autocomplete="off"
                  float-label="Nome"
                  :error="$v.form.nome.$error"
                  :after="afterError"
                />
              </q-field>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5">
              <q-field
                :error="$v.form.idade.$error"
                error-label="Idade da pessoa é obrigatório"
                helper="Campo obrigatório"
                >
                <q-input
                  v-model="form.idade"
                  class="no-margin"
                  autocomplete="off"
                  float-label="Idade"
                  type="tel"
                  :error="$v.form.idade.$error"
                  :after="afterError"
                />
              </q-field>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
              <q-field
                :error="$v.form.sexo.$error"
                error-label="Sexo da pessoa é obrigatório"
                helper="Campo obrigatório"
                >
                <q-select
                  v-model="form.sexo"
                  float-label="Sexo"
                  radio
                  :options="selectOptions"
                  :error="$v.form.sexo.$error"
                  :after="afterError"
                />
              </q-field>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
              <q-field
                :error="$v.form.tipo.$error"
                error-label="Tipo da pessoa é obrigatório"
                helper="Campo obrigatório"
                >
                <q-select
                  v-model="form.tipo"
                  float-label="Tipo"
                  :options="selectOptionsTipo"
                  :error="$v.form.tipo.$error"
                  :after="afterError"
                />
              </q-field>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9" v-show="form.tipo === 'Programador'">
              <q-field
                :error="$v.form.linguagem.$error"
                >
                <q-input
                  v-model="form.linguagem"
                  class="no-margin"
                  autocomplete="off"
                  float-label="Linguagens"
                />
              </q-field>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9" v-show="form.tipo === 'Analista'">
              <q-field
                :error="$v.form.projeto.$error"
                >
                <q-input
                  v-model="form.projeto"
                  class="no-margin"
                  autocomplete="off"
                  float-label="Projetos"
                />
              </q-field>
            </div>
          </div>
          <div class="col-auto">
            <q-btn
              class="submit full-width"
              color="positive"
              @click.native="submit"
              icon-right="save"
              :loading="loading"
              >
                Salvar
              </q-btn>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
import { Notify } from 'quasar'

export default {
  created () {
    this.$root.$on('loadPersonData', this.loadData)
    this.$root.$on('clearFormData', this.clearForm)
  },
  data: () => ({
    loading: false,
    selectOptions: [
      {
        label: 'Masculino',
        value: 'Masculino'
      },
      {
        label: 'Feminino',
        value: 'Feminino'
      }
    ],
    selectOptionsTipo: [
      {
        label: 'Analista',
        value: 'Analista'
      },
      {
        label: 'Programador',
        value: 'Programador'
      }
    ],
    form: {
      nome: null,
      idade: null,
      sexo: null,
      tipo: null,
      linguagem: null,
      projeto: null,
      id: null
    },
    afterError: [
      {
        icon: 'warning',
        error: true
      }
    ]
  }),
  mounted () {
  },
  methods: {
    loadData (person) {
      if (person.linguagem) {
        person.linguagem.split(' ')
      }
      if (person.projeto) {
        person.projeto.split(' ')
      }
      this.form = {
        ...person
      }
    },
    clearForm () {
      setTimeout(() => { this.$v.$reset() }, 0)
      this.form = {
        nome: null,
        idade: null,
        sexo: null,
        tipo: null,
        linguagem: null,
        projeto: null,
        id: null
      }
    },
    notify (options, closeModal) {
      const self = this
      Notify.create({
        ...options,
        onDismiss () {
          self.loading = false
          if (closeModal) {
            self.clearForm()
            self.$emit('event')
          }
        }
      })
    },
    save (form) {
      let formArr = form
      if (!form.id) {
        return this.$Api.post(`person`, JSON.stringify(formArr))
      } else {
        return this.$Api.put(`person/${formArr.id}`, JSON.stringify(formArr))
      }
    },
    submit () {
      this.loading = true
      this.$v.form.$touch()
      if (this.$v.form.$error) {
        this.$q.notify('Campo(s) obrigatório(s) deve ser preenchido(s)')
        this.loading = false
      } else {
        this
          .save(this.form)
          .then((r) => {
            this.notify({
              message: 'Pessoa salva com sucesso!',
              type: 'positive',
              icon: 'sentiment_very_satisfied',
              position: 'bottom',
              timeout: 2000
            }, true)
          })
          .catch((e) => {
            this.notify({
              message: 'Não foi possível salvar os dados da pessoa',
              detail: e.text,
              type: 'negative',
              icon: 'sentiment_very_dissatisfied',
              position: 'bottom',
              timeout: 2000
            }, false)
          })
      }
    }
  },
  name: 'Pessoa',
  validations () {
    const formValidation = {
      form: {
        nome: {
          required
        },
        sexo: {
          required
        },
        idade: {
          required
        },
        tipo: {
          required
        },
        linguagem: { },
        projeto: {}
      }
    }
    return formValidation
  }
}
</script>

<style lang="stylus" scoped>
@import '~variables'

.modal-content-page
  background-color $white
  width calc(100% - 30px)
  max-width 900px
  margin 3vh auto
  position relative
  .selectInput
    margin-top 18px
  .submit
    margin 3vh 0 0 0
</style>
