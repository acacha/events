<template>
    <div>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-description">
            Launch Default Modal
        </button>

        <div id="prova" class="editable">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus nostrum, tempore. At dolore dolorum ea expedita laudantium nam, numquam officiis repudiandae tenetur totam? Autem debitis, ducimus ea quia quod sapiente.
        </div>

        <div class="modal fade" id="modal-description">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Description</h4>
                    </div>
                    <div class="modal-body">
                        <div id="editor">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus nostrum, tempore. At dolore dolorum ea expedita laudantium nam, numquam officiis repudiandae tenetur totam? Autem debitis, ducimus ea quia quod sapiente.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <widget :loading="loading">
            <p slot="title">Events</p>
            <div v-cloak>

                <table class="table table-bordered table-hover">
                    <tbody><tr>
                        <th style="width: 10px">#</th>
                        <th>Event</th>
                        <th>Completed</th>
                        <th>Description</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="(event, index) in filteredEvents">
                        <td>{{ index + 1 }}</td>
                        <td>{{ event.name }}</td>
                        <td> <toggle-button :value="true"/> </td>
                        <td class="description"> {{ event.description }} </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="event.created_at" v-text="human(event.created_at)"></a>
                        </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="event.updated_at" v-text="human(event.updated_at)"></a>
                        </td>
                        <td>TODO actions here</td>
                    </tr>
                    </tbody>
                </table>
                <!--<ul>-->
                    <!--<li v-for="event in filteredEvents" :class="{ completed: isCompleted(event) }"-->
                        <!--@dblclick="updateEvent(event)">-->
                        <!--<input type="text" v-if="event == editedEvent">-->
                        <!--<div v-else>-->
                            <!--{{event.name}}-->
                            <!--<i class="fa fa-pencil" aria-hidden="true" @click="updateEvent(event)"></i>-->
                            <!--<i class="fa fa-refresh fa-spin fa-lg" v-if=" event.id === eventBeingDeleted"></i>-->
                            <!--<i class="fa fa-times" aria-hidden="true" @click="deleteEvent(event)"></i>-->
                        <!--</div>-->

                    <!--</li>-->
                <!--</ul>-->
                <div class="btn-group">
                    <button @click="show('all')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'all' }">All</button>
                    <button @click="show('completed')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'completed' }">Completed</button>
                    <button @click="show('pending')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'pending' }">Pending</button>
                </div>
                <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('user_id') }">
                    <label for="user_id">User</label>
                    <transition name="fade">
                        <span v-text="form.errors.get('user_id')" v-if="form.errors.has('user_id')" class="help-block"></span>
                    </transition>
                    <!--<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">-->
                    <users @select="userSelected" id="user_id" name="user_id" v-model="form.user_id" :value="form.user_id"></users>
                </div>
                <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('name') }">
                    <label for="name">Event name</label>
                    <transition name="fade">
                        <span v-text="form.errors.get('name')" v-if="form.errors.has('name')" class="help-block"></span>
                    </transition>
                    <input @input="form.errors.clear('name')" class="form-control" type="text" v-model="form.name" id="name" name="name" @keyup.enter="addEvent">
                </div>
            </div>
            <p slot="footer">
                <button :disabled="form.submitting || form.errors.any()" id="add" @click="addEvent" class="btn btn-primary">
                    <i class="fa fa-refresh fa-spin fa-lg" v-if="form.submitting"></i>
                    Afegir
                </button>
            </p>
        </widget>

        <message title="Message" message="" color="info"></message>
    </div>
</template>

<style src="quill/dist/quill.snow.css"></style>

<style src="medium-editor/dist/css/medium-editor.min.css"></style>
<style src="medium-editor/dist/css/themes/default.min.css"></style>

<style>

    .description {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    li.completed {
        text-decoration : line-through;
    }

    [v-cloak] { display: none; }

    li.active {
        background-color: blue;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity 3s ease;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>

<script>

  import Users from './Users'
  import Form from 'acacha-forms'
  import Quill from 'quill'
  import MediumEditor from 'medium-editor'

  // visibility filters
  var filters = {
    all: function (events) {
      return events
    },
    pending : function (events) {
      return events.filter(function (event) {
        return !event.completed
      })
    },
    completed: function (events) {
      return events.filter(function (event) {
        return event.completed
      })
    }
  }

  const API_URL = '/api/v1/events'

  import { wait } from './utils.js'
  import moment from 'moment'
  import {config} from '../config/events.js'

  export default {
    components: { Users },
    data() {
      return {
        quill: true,
        loading: false,
        editedEvent: null,
        filter: 'all',
        events: [],
        eventBeingDeleted: null,
        form: new Form({ user_id : 1, name: 'canvia nom tasca siusplau'})
      }
    },
    computed: {
      filteredEvents() {
        return filters[this.filter](this.events)
      }
    },
    watch: {
      events: function() {
//          localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(this.events))
      }
    },
    methods: {
      human(date) {
        return moment(date).fromNow()
      },
      userSelected(user) {
        this.form.user_id = user.id
      },
      show(filter) {
        this.filter = filter
      },
      addEvent() {
        let url = API_URL
        this.form.post(url).then( (response) =>  {
          this.events.push({ name : this.form.name , user_id: this.form.user_id , completed : false})
          this.form.name=''
        }).catch((error) => {
          flash(error.message)
        })
      },
      isCompleted(event) {
        return event.completed
      },
      deleteEvent(event) {

        let url = '/api/v1/events/' + event.id
        this.eventBeingDeleted = event.id
        axios.delete(url).then( (response) => {
          this.events.splice( this.events.indexOf(event) , 1 )
        }).catch( (error) => {
          flash(error.message)
        }).then(
          this.eventBeingDeleted = null
        )
      },
      updateEvent(event){
        this.editedEvent = event
      }
    },
    mounted() {

      new Quill('#editor', {
        theme: 'snow'
      })

      new MediumEditor('.editable');

      let url = API_URL
      this.loading = true
      axios.get(url).then((response) =>  {
        this.events = response.data;
      }).catch((error) => {
        console.log(error.message)
        flash(error.message)
      }).then(() => {
        this.loading = false
      })
    }
  }
</script>
