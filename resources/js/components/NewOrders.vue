<template>
<v-layout row wrap>
  <v-flex xs12 lg6>
  <v-toolbar color="blue darken-4" dark dense>
    <v-toolbar-title>Nowe zamówienie</v-toolbar-title>
    <v-spacer></v-spacer>
    <info-dialog :message="newOrderInfo"></info-dialog>
  </v-toolbar>
  <v-card class="pa-1">
    <v-card-text>
      <h4>Dane klienta</h4>
      <v-combobox
        label="Imię i nazwisko"
        v-model="fullname"
        :rules="[() => !!fullname || 'To pole jest wymagane']"
        :items="states"
        counter="50"
        hide-no-data
        hide-selected
        prepend-icon="account_box"
      ></v-combobox>

      <v-combobox
        label="Numer telefonu"
        return-masked-value
        mask="### ### ###"
        counter="11"
        hide-no-data
        hide-selected
        prepend-icon="phone"
      ></v-combobox>

      <v-text-field
        label="Zaliczka w PLN"
        type="number"
        prepend-icon="attach_money"
        suffix="zł"
      ></v-text-field>

      <h4>Transport</h4>
      <hr>
      <v-radio-group v-model="transportType" row>
        <v-radio label="W mieście" value="city-delivery"></v-radio>
        <v-radio label="Poza miastem" value="outside-city-delivery"></v-radio>
        <v-radio label="Darmowy" value="free-delivery"></v-radio>
      </v-radio-group>
      <v-combobox v-show="transportType=='outside-city-delivery'"
        label="Miejscowość"
        v-model="model"
        :items="states"
        counter="50"
        hide-no-data
        hide-selected
        prepend-icon="location_on"
      ></v-combobox>
      <v-text-field v-show="transportType=='outside-city-delivery'"
        label="Odległość w Km"
        type="number"
        prepend-icon="map"
        suffix="Km"
      ></v-text-field>
      <v-flex xs12 lg6>
      <v-menu
        ref="menu1"
        v-model="menu1"
        :close-on-content-click="false"
        :nudge-right="40"
        lazy
        transition="scale-transition"
        offset-y
        full-width
        max-width="290px"
        min-width="290px">
        <template v-slot:activator="{ on }">
          <v-text-field
            label="Ostateczny termin realizacji"
            v-model="dateFormatted"
            persistent-hint
            prepend-icon="event"
            @blur="date = parseDate(dateFormatted)"
            v-on="on"
          ></v-text-field>
        </template>
      <v-date-picker v-model="date" no-title @input="menu1 = false"></v-date-picker>
      </v-menu>
      </v-flex>
      <hr>

      <h4>Promocje</h4>
      <p>Łączna kwota zamówień klienta to xx xxx zł </br> Ostatnie zamówienie opiewało na kwotę xxx zł </p>
        <v-layout wrap>
          <v-flex xs12 md6><v-text-field label="Rabat w %" v-model="getPercentDiscount"></v-text-field></v-flex>
          <v-flex xs12 md6><v-text-field label="Rabat w PLN" suffix="zł" v-model="getMoneyDiscount"></v-text-field></v-flex>
        </v-layout>
      <hr>

      <h1>Razem: {{ totalValueInPennyShowed }} zł</h1>
      <p class="grey--text">Jeśli chcesz wydrukować to zamówienie jeszcze raz po prostu kliknij zatwierdź</p>
      <v-card-actions>
        <v-btn  color="blue-grey" dark @click="openGlassPaneDialog">DODAJ PRODUKT</v-btn>
        <v-layout align-center justify-end><v-btn color="success">Zatwierdź</v-btn></v-layout>
      </v-card-actions>
    </v-card-text>
  </v-card>
  </v-flex>


  <!--DIALOG DODAJ/EDYTUJ TAFLĘ SZKŁA-->
  <glass-pane-dialog :editing-index="editedIndex" :obj="sendObject"></glass-pane-dialog>
  <!--KONIEC DIALOGU-->
  <!--PRAWA STRONA-->
  <v-flex xs12 lg6>
  <v-toolbar color="indigo" dark dense>
    <v-toolbar-title>Tafle szkła</v-toolbar-title>
    <v-spacer></v-spacer>
    <info-dialog :message="paneSectionInfo"></info-dialog>
  </v-toolbar>
    <v-btn block color="blue-grey" dark @click="openGlassPaneDialog">DODAJ PRODUKT</v-btn>
    <v-data-table
      :headers="headers"
      :items="producs"
      :expand="expand"
      class="elevation-1"
      hide-actions
      item-key="name"
      :rows-per-page-items="rowsPerPageItems"
      :pagination.sync="pagination"
    >
      <template v-slot:items="props">
        <tr @click="props.expanded = !props.expanded">
          <td><b>{{ props.item.name }}</b></td>
          <td class="text-xs-right">{{ props.item.quantity }} szt</td>
          <td class="text-xs-right">{{ props.item.price }} zł</td>
          <td class="justify-center layout px-0">
            <v-icon class="mr-2 mt-2" @click="editItem(props.item)">edit</v-icon>
            <v-icon class="mt-2" @click="deleteItem(props.item)">delete</v-icon>
          </td>
        </tr>
      </template>
      <template v-slot:no-data>
          <p class="text-xs-center success--text">Użyj przycisku dodaj produkt aby wstawić produkty do zamówienia</p>
      </template>
      <template v-slot:no-results>
        <p class="text-xs-center success--text">Brak produktów - użyj przycisk dodaj produkt</p>
      </template>
      <template v-slot:expand="props">
        <v-card flat>
          <v-card-text>Peek-a-boo!{{ props.item.name }}</v-card-text>
        </v-card>
      </template>
    </v-data-table>
    <div class="text-xs-center pt-2">
      <v-pagination v-model="pagination.page" :length="pages"></v-pagination>
    </div>
  </v-flex>
</v-layout>
</template>




<script>
  import InfoDialog from './helpers/InfoDialog';
  import GlassPaneDialog from './helpers/GlassPaneDialog';
  export default {
    components: {InfoDialog, GlassPaneDialog},
    data: () => ({
      expand: false,
      rowsPerPageItems: [10, 20, 30, 40],
      pagination: {
        rowsPerPage: 10
      },
      isAddGlassPaneOpen: false,
      date: new Date().toISOString().substr(0, 10),
      dateFormatted: nd2.formatDate(new Date().toISOString().substr(0, 10)),
      menu1: false,
      model: null,
      fullname:'',
      inputvalue: 0,
      states: [
        'Alabama', 'Alaska', 'American Samoa', 'Arizona',
        'Arkansas', 'California', 'Colorado', 'Connecticut',
        'Delaware', 'District of Columbia', 'Federated States of Micronesia',
        'Florida', 'Georgia', 'Guam', 'Hawaii', 'Idaho',
        'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky',
        'Louisiana', 'Maine', 'Marshall Islands', 'Maryland',
        'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi',
        'Missouri', 'Montana', 'Nebraska', 'Nevada',
        'New Hampshire', 'New Jersey', 'New Mexico', 'New York',
        'North Carolina', 'North Dakota', 'Northern Mariana Islands', 'Ohio',
        'Oklahoma', 'Oregon', 'Palau', 'Pennsylvania', 'Puerto Rico',
        'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee',
        'Texas', 'Utah', 'Vermont', 'Virgin Island', 'Virginia',
        'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
      ],
      transportType: 'city-delivery',
      percentDiscount: 0,
      moneyDiscount: 0,
      totalValueInPenny: 1000,
      totalValueInPennyShowed: 0,
      newOrderInfo: 'W tej sekcji uzupełnia się informacje dotyczące konkretnego zlecenia.' +
        'Jedyne wymagane pole do uzupełnienia to imię i nazwisko klienta',
      paneSectionInfo: 'To jest miejsce na produkty dotyczące tego zlecenia. Prdukty po dodaniu można ' +
        'wciąż swobodnie zmieniać i edytować a nawet usuwać.',
      confirmDeleteMessage: 'Na pewno chcesz usunąć ten produkt ze zlecenia?',
      headers: [
        {text: 'Nazwa', value: 'name', align: 'left'},
        {text: 'Ilość', value: 'quantity'},
        {text: 'Cena', value: 'price'},
        {text: 'Akcje', value: 'name', sortable: false}
      ],
      producs: [],
      editedIndex: -1,
      editedItem: { name: '', quantity: 0, price: 0},
      defaultItem: { name: '', quantity: 0, price: 0},
      sendObject: {},
    }),

    methods: {
      openGlassPaneDialog() {nd2.openGlassPaneDialog();},
      closeGlassPaneDialog() {nd2.closeGlassPaneDialog();},
      parseDate(date){return nd2.parseDate(date)},
      lisen() {
        EventBus.$on('closeAddGlassPaneDialog', () => {this.sendObject = {}; });
      },
      editItem (item) {
        this.sendObject = item;
        this.editedIndex = this.producs.indexOf(item);
        this.editedItem = Object.assign({}, item);
        this.openGlassPaneDialog();
      },
      deleteItem (item) {
        const index = this.producs.indexOf(item);
        confirm(this.confirmDeleteMessage) && this.producs.splice(index, 1)
      },
      close () {
        this.closeGlassPaneDialog();
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem);
          this.editedIndex = -1
        }, 300)
      },
      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.producs[this.editedIndex], this.editedItem)
        } else {this.producs.push(this.editedItem)}
        this.close()
      }
    },

    computed: {
      computedDateFormatted() {return nd2.formatDate(this.date)},
      getPercentDiscount: {
        get: function(){
          let total = this.totalValueInPenny;
          let result = (total - (total * this.percentDiscount / 100));
          this.totalValueInPennyShowed = Number((result).toFixed(2));
          return this.percentDiscount ;
        },
        set: function(perc) {
          let validperc = nd2.validateNumber(perc);
          let result = this.totalValueInPenny * (validperc / 100);
          this.moneyDiscount = Number((result).toFixed(2));
        },
      },
      getMoneyDiscount: {
        get: function(){
          this.totalValueInPennyShowed = this.totalValueInPenny - this.moneyDiscount;
          return this.moneyDiscount;
        },
        set: function(money) {
          let validmoney = nd2.validateNumber(money);
          let total  = this.totalValueInPenny;
          if (total > 0) {
            let result = validmoney * 100/total;
            this.percentDiscount = Number((result).toFixed(2));
          }
           else {this.percentDiscount = 0;}
        },
      },
      pages () {
        if (this.pagination.rowsPerPage == null || this.pagination.totalItems == null) return 0;
        return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
      },
    },
    watch: {
      date (val) {this.dateFormatted = nd2.formatDate(this.date)},
      dialog (val) {val || this.close()},
    },
    created() {this.lisen();},
  }
</script>
