<template>
<v-layout row wrap>
  <v-flex xs12 lg6>
  <v-toolbar color="blue darken-4" dark dense>
    <info-dialog :message="newOrderInfo"></info-dialog>
    <v-toolbar-title>Nowe zamówienie</v-toolbar-title>
  </v-toolbar>
  <v-card class="pa-1">
    <v-card-text>
      <h4>Dane klienta</h4>
      <v-combobox
        label="Imię i nazwisko"
        :rules="[() => !!choosenClient || 'To pole jest wymagane']"
        :items="clients"
        item-text="full_name"
        counter="50"
        hide-no-data
        prepend-icon="account_box"
        @change="choosedClient"
      ></v-combobox>

      <v-combobox
        label="Numer telefonu"
        return-masked-value
        mask="### ### ###"
        counter="11"
        hide-no-data
        hide-selected
        prepend-icon="phone"
        :value="choosenPhoneNumber"
        @change="choosedPhoneNumber"
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
        :items="placeOfDeliveries"
        item-text="name"
        counter="50"
        hide-no-data
        hide-selected
        prepend-icon="location_on"
        @change="choosedPlaceOfDelivery"
      ></v-combobox>
      <v-text-field v-show="transportType=='outside-city-delivery'"
        label="Odległość w Km"
        type="number"
        prepend-icon="map"
        suffix="Km"
        v-model="distanceInKm"
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
  <!--<glass-pane-dialog :editing-index="editedIndex" :obj="sendObject"></glass-pane-dialog>-->
  <glass-pane-dialog></glass-pane-dialog>
  <!--KONIEC DIALOGU-->
  <!--PRAWA STRONA-->
  <v-flex xs12 lg6>
  <v-toolbar color="indigo" dark dense>
    <info-dialog :message="paneSectionInfo"></info-dialog>
    <v-toolbar-title>Tafle szkła</v-toolbar-title>
  </v-toolbar>
    <v-btn block color="blue-grey" dark @click="openGlassPaneDialog">DODAJ PRODUKT</v-btn>
    <v-data-table
      :headers="headers"
      :items="products"
      :expand="expand"
      class="elevation-1"
      hide-actions
      item-key="index"
      :rows-per-page-items="rowsPerPageItems"
      :pagination.sync="pagination"
    >
      <template v-slot:items="props">
        <tr @click="props.expanded = !props.expanded">
          <td><b>{{ props.item.glass_model_name }}</b></td>
          <td class="text-xs-right">{{ props.item.quantity }} szt</td>
          <td class="text-xs-right">{{ Math.round(props.item.price,2)/100 }} zł</td>
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
          <v-card-text>
            <v-layout>
              <v-flex xs12 md6> Szlif: {{ props.item.cut_model_name }}</v-flex>
              <v-flex xs12 md6> Wymiary: {{props.item.width}} x {{props.item.height}} {{props.item.unitGlassPaneDimension}}</v-flex>
            </v-layout>
          </v-card-text>
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
      expand: false, isAddGlassPaneOpen: false, menu1: false,
      rowsPerPageItems: [10, 20, 30, 40], pagination: { rowsPerPage: 10},
      date: new Date().toISOString().substr(0, 10),
      dateFormatted: nd2.formatDate(new Date().toISOString().substr(0, 10)),
      model: null,
      fullname:'',
      transportType: 'city-delivery',
      percentDiscount: 0, moneyDiscount: 0, totalValueInPenny: 0, totalValueInPennyShowed: '0 zł',
      newOrderInfo: 'W tej sekcji uzupełnia się informacje dotyczące konkretnego zlecenia. Jedyne wymagane pole do uzupełnienia to imię i nazwisko klienta',
      paneSectionInfo: 'To jest miejsce na produkty dotyczące tego zlecenia. Prdukty po dodaniu można wciąż swobodnie zmieniać i edytować a nawet usuwać.',
      confirmDeleteMessage: 'Na pewno chcesz usunąć ten produkt ze zlecenia?',
      headers: [
        {text: 'Nazwa', value: 'glass_model_name', align: 'left'},
        {text: 'Ilość', value: 'quantity'},
        {text: 'Cena', value: 'price'},
        {text: 'Akcje', value: 'glass_model_id', sortable: false}
      ],
      productCurrentIndex: 0,
      products: [], clients: [], placeOfDeliveries: [],
      allPlaceOfDeliveries: [], allClients: [],
      choosenPlaceOfDelivey: {}, choosenClient: {}, choosenPhoneNumber: '',
      distanceInKm: 0,
    }),
    created() {
      this.getAllClients();
      this.getAllPlaceOfDeliveries();
      this.lisen();
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
    watch: {date (val) {this.dateFormatted = nd2.formatDate(this.date)},dialog (val) {val || this.close()},},

    methods: {
      openGlassPaneDialog() {nd2.openGlassPaneDialog();},
      closeGlassPaneDialog() {nd2.closeGlassPaneDialog();},
      parseDate(date){return nd2.parseDate(date)},
      lisen() {
        EventBus.$on('addGlassPaneToProductsList', (obj) => {this.addProduct(obj); });
      },
      editItem (item) {EventBus.$emit('openToEditGlassPaneDialog', item); this.openGlassPaneDialog();},
      deleteItem (item) {const index = this.products.indexOf(item); confirm(this.confirmDeleteMessage) && this.products.splice(index, 1)},
      close () {this.closeGlassPaneDialog();},
      addProduct(obj) {
        // add new or else update product
        if ((typeof(obj.index) === "undefined") || (obj.index === -1)) {
          obj.index = this.productCurrentIndex;
          this.productCurrentIndex++;
          this.products.push(obj);
        } else {
          this.products.splice(obj.index, 1, obj);
        }
      },
      //get from database
      getAllClients() {axios.get('/api/clients/all').then(res =>  this.gettedAllClients(res.data)).catch(e => console.log(e));},
      getAllPlaceOfDeliveries() {axios.get('/api/places-of-deliveries/all').then(res =>  this.gettedAllPlaceOfDeliveries(res.data)).catch(e => console.log(e));},
      //when getted from database
      gettedAllClients(res){
        this.allClients = res;

        let testObj = {id: 1, full_name: 'Jan Testowy', phone_number: '678 876 543', place_of_delivery_id: 1, default_distance: 10};
        this.allClients.unshift(testObj);
        this.clients = this.allClients;
      },
      gettedAllPlaceOfDeliveries(res) {
        this.allPlaceOfDeliveries = res;
        this.setAllPlacesOfDelivery();
      },
      //when choosed from inputs
      choosedClient(obj) {
        if (typeof(obj) === 'string'){
          this.createNewClient(obj);
        } else {this.choosenClient = obj;}
        this.changePhoneNumber();
      },
      choosedPhoneNumber(val){
        this.choosenPhoneNumber = val;
        if (this.newClientExist()){this.allClients[0].phone_number = val}
      },
      choosedPlaceOfDelivery(obj){
        this.choosenPlaceOfDelivery = obj;
        this.changeDistanceInKm();
      },
      //change the value of (recount)
      changePhoneNumber(){
        let clientNumber = this.choosenClient.phone_number;
        let setNumber = '';
        if (this.newClientExist()){setNumber = this.allClients[0].phone_number}
        if (clientNumber){
          setNumber = clientNumber;
        }
        this.choosenPhoneNumber = setNumber;
      },
      changeDistanceInKm(){
        let distance = 0;
        if (this.choosenPlaceOfDelivey){
          distance = this.choosenPlaceOfDelivey.distance*1;
        }
        this.distanceInKm = distance;
      },
      //set some value to other
      setAllPlacesOfDelivery() {
        let obj = {id: 0, name: 'Brak', distance: 0};
        this.allPlaceOfDeliveries.unshift(obj);
        this.placeOfDeliveries = this.allPlaceOfDeliveries;
      },
      createNewClient(name){
        if (name !==  '') {
          let newClient = {id: 0, phone_number: null, place_of_delivery_id: null, default_distance: null};
          newClient.full_name = 'NOWY: '+name;
          if (!this.newClientExist()){this.allClients.unshift({});}
          //anyway create new client or update it on place 0 in allClients array
          this.allClients.splice(0, 1, newClient);
          this.choosenClient = newClient;
        } else {
          // if we dont named our client or choose one
          this.choosenClient = null;
        }
      },
      newClientExist(){return !((this.allClients.length > 0) && (this.allClients[0].id !== 0));},
    },
  }
</script>
