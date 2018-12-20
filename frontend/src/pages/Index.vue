<template>
  <q-page class="flex">
    <div class="content">
      <h1>Listagem de funcionário(s)</h1>
      <q-table
        color="secondary"
        :data="tableData"
        :columns="columns"
        :filter="filter"
        row-key="id"
      >
        <template slot="top-left" slot-scope="props">
          <q-search
            hide-underline
            color="secondary"
            v-model="filter"
            placeholder="Pesquise"
            class="col-6"
          />
        </template>
        <q-tr :id="props.row.id" slot="body" slot-scope="props" :props="props"  class="cursor-pointer" >
          <q-td key="id" :props="props">
            {{props.row.id}}
          </q-td>
          <q-td key="nome" :props="props">
            {{props.row.tipo}} - {{props.row.nome}}
          </q-td>
          <q-td key="idade" :props="props">
            {{props.row.idade}}
          </q-td>
          <q-td key="sexo" :props="props">
            {{props.row.sexo}}
          </q-td>
           <q-td key="generico" :props="props">
              {{showNameFuncao(props.row)}}
            </q-td>
          <q-td>
             <q-btn flat round dense icon="more_vert">
              <q-popover>
                <q-list link>
                  <q-item v-close-overlay @click.native="loadCadastro(props.row)">
                    Editar
                  </q-item>
                  <q-item v-close-overlay @click.native="deletePerson(props.row)">
                    Apagar
                  </q-item>
                </q-list>
              </q-popover>
            </q-btn>
          </q-td>
        </q-tr>
      </q-table>
    </div>
    <q-btn
      round
      color="primary"
      @click.native="openedModal = true"
      class="fixed"
      icon="add"
      style="right: 18px; bottom: 18px"
    />

    <q-modal
      v-model="openedModal"
      :content-css="{minWidth: '80vw', minHeight: '80vh'}"
      :maximized="true"
      :no-esc-dismiss="true"
      :no-backdrop-dismiss="true"
      class="neutral"
      >
        <q-modal-layout>
          <q-toolbar slot="header">
            <q-btn
              flat
              round
              dense
              @click.native="closeModal"
              v-close-overlay
              icon="close"
            />
            <q-toolbar-title class="absolute-center">
              Manutenção de Pessoa
            </q-toolbar-title>
          </q-toolbar>
          <Cadastro @event="closeModal" />
        </q-modal-layout>
    </q-modal>
  </q-page>
</template>

<style>
</style>

<script>
import Cadastro from '../components/Cadastro.vue'

export default {
  components: { Cadastro },
  data: () => ({
    filter: '',
    openedModal: false,
    columns: [
      {
        name: 'id',
        required: true,
        label: '#',
        align: 'center',
        field: 'id',
        sortable: true
      },
      {
        name: 'nome',
        required: true,
        label: 'Nome',
        align: 'center',
        field: 'nome',
        sortable: true
      },
      {
        name: 'idade',
        required: true,
        label: 'Idade',
        align: 'center',
        field: 'idade',
        sortable: true
      },
      {
        name: 'sexo',
        required: true,
        label: 'Sexo',
        align: 'center',
        field: 'sexo',
        sortable: true
      },
      {
        name: 'generico',
        required: true,
        label: '',
        align: 'center',
        field: 'generico',
        sortable: true
      }
    ],
    tableData: []
  }),
  mounted () {
    this.loadPerson()
  },
  methods: {
    showNameFuncao (person) {
      return (person.tipo === 'Analista') ? `Projetos: ${person.projeto}` : `Linguagens: ${person.linguagem}`
    },
    loadCadastro (person) {
      this.$root.$emit('loadPersonData', person)
      this.openedModal = true
    },
    loadPerson () {
      this
        .$Api
        .get('person')
        .then((res) => {
          console.log(res)
          this.tableData = res.data
        })
    },
    closeModal () {
      this.openedModal = false
      this.$root.$emit('clearFormData')
      this.loadPerson()
    },
    deletePerson (person) {
      this.$q.dialog({
        title: 'Atenção',
        message: 'Deseja realmente apagar essa pessoa?',
        cancel: 'Não',
        ok: 'Sim',
        preventClose: true
      }).then(() => {
        return this.$Api.delete(`person/${person.id}`)
      }).then(() => {
        const self = this
        this.$q.notify({
          message: 'Pessoa apagada com sucesso!',
          type: 'positive',
          icon: 'sentiment_very_satisfied',
          timeout: 1000,
          onDismiss () {
            self.loadPerson()
          }
        })
      })
    }
  },
  name: 'PageIndex'
}
</script>

<style lang="stylus" scoped>
@import '~variables'
.content
  background-color #FFF
  padding 1vh
  width 100%
  h1
    width 100%
    background-color $dark
    padding 10px
    text-align center
    color $neutral
    font-size 3vh

</style>
