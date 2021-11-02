<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 mx-auto">
        <div class="olm_questions_form">
          <div class="form-group">
            <label for="">Questions Title</label>
            <input
              type="text"
              class="form-control"
              name=""
              v-model="form_title"
            />
          </div>
          <form
            action="#"
            id="olm_questions_form"
            @submit.prevent="save_fields"
          >
            <div
              class="olm_ques_form_item mb-2"
              v-for="(fields, main_index) in form_fields"
              :key="main_index"
            >
              <div class="card">
                <div class="card-body pb-0">
                  <div class="olm_ques_item_head">
                    <div class="row">
                      <div class="col-md-9">
                        <div class="form-group">
                          <quill-editor
                            :id="`ques_${fields.field_id}_title`"
                            v-model="fields.questions_title"
                            :options="editorOption"
                          />
                          <input
                            type="hidden"
                            :name="`ques_${fields.field_id}_title`"
                            :value="fields.questions_title"
                          />
                          <!-- <input
                            type="text"
                            class="form-control ques_form_title"
                            :id="`ques_${fields.field_id}_title`"
                            placeholder="Untitled Questions"
                            :name="`ques_${fields.field_id}_title`"
                            v-model="fields.questions_title"
                          /> -->
                        </div>
                        <!-- <input
                          type="hidden"
                          :value="fields.select_type"
                          :name="`ques_${fields.field_id}_type`"
                          :id="`ques_${fields.field_id}_type`"
                        /> -->
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <select
                            class="form-control"
                            :id="`ques_${fields.field_id}_type`"
                            :name="`ques_${fields.field_id}_type`"
                            v-model="fields.select_type"
                          >
                            <option
                              v-for="types in fields.questions_type"
                              :value="types.value"
                              :key="types.name"
                              :data-type="types.value"
                            >
                              {{ types.name }}
                            </option>
                          </select>
                        </div>
                        <div>
                          <div v-if="!fields.questions_photo">
                            <input
                              type="file"
                              :name="`ques_${fields.field_id}_photo`"
                              :id="`ques_${fields.field_id}_photo`"
                              class="custom-input-file custom-input-file--2"
                              :on="fields.questions_photo"
                              @change="ques_title_photo($event, main_index)"
                            />
                            <label :for="`ques_${fields.field_id}_photo`">
                              <i class="fa fa-upload"></i>
                              <span>File Upload</span>
                            </label>
                          </div>
                          <div
                            v-if="fields.questions_photo"
                            class="position-relative"
                          >
                            <img
                              :src="get_ques_title_photo(main_index)"
                              alt=""
                              class="img-fluid"
                            />
                            <div
                              class="ques_title_photo"
                              @click="remove_title_photo(main_index)"
                            >
                              <i class="fas fa-times"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end head -->
                  <div
                    class="item_show_content"
                    v-if="
                      fields.select_type == 'multiple_questions_3' ||
                      fields.select_type == 'checkboxes_questions_4'
                    "
                  >
                    <div
                      class="item_show_on_expand"
                      data-id=""
                      v-for="(option, index) in fields.options"
                      :key="index"
                    >
                      <div class="row align-items-center">
                        <div class="col-md-8">
                          <div
                            class="form-group option_item d-flex align-items-center"
                          >
                            <input
                              type="text"
                              class="form-control"
                              v-model="option.input_name"
                              :name="`ans_${option.option_id}_opt_${fields.field_id}`"
                              :readonly="fields.ans_mode"
                              @click="
                                fields.ans_mode
                                  ? ans_bind_click(
                                      main_index,
                                      option,
                                      'ans_' +
                                        option.option_id +
                                        '_opt_' +
                                        fields.field_id
                                    )
                                  : null
                              "
                              :style="
                                fields.ans_mode
                                  ? option.ans
                                    ? 'color: #fff;background: #37A000; '
                                    : ''
                                  : ''
                              "
                            />
                            <span class="align-self-end" v-if="option.ans">
                              <i
                                class="fas fa-check text-success"
                                style="font-size: 20px"
                              ></i>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div v-if="fields.ans_mode == false">
                            <div v-if="!option.input_photo">
                              <input
                                type="file"
                                :name="`ans_${option.option_id}_opt_photo_${fields.field_id}`"
                                :id="`ans_${option.option_id}_opt_photo_${fields.field_id}`"
                                class="custom-input-file custom-input-file--2"
                                @change="
                                  ans_option_photo($event, main_index, index)
                                "
                              />
                              <label
                                :for="`ans_${option.option_id}_opt_photo_${fields.field_id}`"
                              >
                                <i class="fa fa-upload"></i>
                                <span>File Upload</span>
                              </label>
                            </div>
                            <div
                              v-if="option.input_photo"
                              class="position-relative"
                            >
                              <img
                                :src="get_ans_option_photo(main_index, index)"
                                alt=""
                                class="img-fluid"
                              />
                              <div
                                class="ques_title_photo"
                                @click="
                                  remove_ans_option_photo(main_index, index)
                                "
                              >
                                <i class="fas fa-times"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="col-md-2 text-right"
                          v-show="index != 0"
                          v-if="fields.ans_mode == false"
                        >
                          <span
                            class="btn option_remove show_on_focus"
                            @click="
                              removeOption(
                                main_index,
                                index,
                                'ans_' +
                                  option.option_id +
                                  '_opt_' +
                                  fields.field_id
                              )
                            "
                          >
                            <i class="fas fa-times"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div
                      class="add_option text-left show_on_focus"
                      v-if="fields.ans_mode == false"
                    >
                      <button
                        @click="addNewOption(main_index)"
                        type="button"
                        class="btn btn-success mb-2 mr-1"
                      >
                        <i class="fas fa-plus mr-1"></i> Add
                      </button>
                    </div>
                  </div>
                  <div
                    class="item_show_content"
                    v-if="fields.select_type == 'shot_questions_1'"
                  >
                    <div class="item_show_on_expand">
                      <div class="row align-items-center">
                        <div class="col-md-8">
                          <div class="form-group">
                            <input
                              type="text"
                              :id="`ans_${fields.field_id}_shot_questions`"
                              class="form-control"
                              :name="`ans_${fields.field_id}_shot_questions`"
                              placeholder="Short answer text"
                              :readonly="fields.shouldDisable"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="item_show_content"
                    v-if="fields.select_type == 'paragraph_questions_2'"
                  >
                    <div class="item_show_on_expand">
                      <div class="row align-items-center">
                        <div class="col-md-8">
                          <div class="form-group">
                            <textarea
                              :id="`ans_${fields.field_id}_long_questions`"
                              class="form-control"
                              placeholder="Long answer text"
                              :name="`ans_${fields.field_id}_long_questions`"
                              :readonly="fields.shouldDisable"
                              rows="2"
                            ></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="item_show_content"
                    v-if="fields.select_type == 'file_questions_5'"
                  >
                    <div class="item_show_on_expand">
                      <div class="row align-items-center">
                        <div class="col-md-8">
                          <div class="form-group">
                            <input
                              type="text"
                              :id="`ans_${fields.field_id}_photo_questions`"
                              class="form-control"
                              :name="`ans_${fields.field_id}_photo_questions`"
                              placeholder="File Upload Answer"
                              :readonly="fields.shouldDisable"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer show_on_focus pl-0">
                    <div class="row">
                      <div class="col-md-4 mr-auto">
                        <div class="d-flex align-items-center">
                          <div
                            @click="set_answer(main_index)"
                            v-if="
                              fields.select_type == 'multiple_questions_3' ||
                              fields.select_type == 'checkboxes_questions_4'
                            "
                          >
                            <span class="btn btn-info">Set Answer</span>
                          </div>
                          <span class="ml-3 d-flex align-items-center">
                            <span> {{ fields.points }} points </span>
                            <span
                              v-if="
                                fields.select_type == 'shot_questions_1' ||
                                fields.select_type == 'paragraph_questions_2'
                              "
                            >
                              <input
                                type="number"
                                class="form-control w-50"
                                v-model="fields.points"
                              />
                            </span>
                          </span>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div
                          class="d-flex field_footer justify-content-end"
                          v-if="fields.ans_mode == false"
                        >
                          <div @click="fields_copy(main_index)">
                            <i class="far fa-copy field_copy"></i>
                          </div>
                          <div class="ml-4" @click="fields_delete(main_index)">
                            <i class="far fa-trash-alt field_delete"></i>
                          </div>
                        </div>
                        <span
                          class="btn btn-success"
                          v-if="fields.ans_mode == true"
                          @click="done_answer(main_index)"
                          >done</span
                        >
                      </div>
                      <div class="col-md-3">
                        <div
                          v-if="fields.ans_mode == true"
                          class="d-flex align-items-center"
                        >
                          <input
                            type="number"
                            :id="`ans_${fields.field_id}_points`"
                            class="form-control ml-auto w-50"
                            :name="`ans_${fields.field_id}_points`"
                            v-model="fields.points"
                          />
                          <span class="ml-2"> Points</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 mx-auto text-center pt-2">
              <button type="submit" class="btn btn-success mx-auto sm">
                <i class="fas fa-plus mr-1"></i> Save
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-2">
        <button class="btn btn-success w-100p" @click="add_new_fields">
          <i class="fas fa-plus mr-2"></i>Add
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";

import { quillEditor } from "vue-quill-editor";
export default {
  components: {
    quillEditor,
  },
  data() {
    let dynamic_id = 567;
    let option_dy_id = 567;
    return {
      editorOption: {
        modules: {
          toolbar: [
            [{ header: [1, 2, 3, 4, false] }],
            ["bold", "italic", "underline"],
            ["image", "code-block"],
            [{ align: [] }],
            [{ color: [] }, { background: [] }],
            [{ list: "ordered" }, { list: "bullet" }],
            [{ font: [] }],
          ],
        },
      },

      dynamic_id: dynamic_id,
      option_dy_id: option_dy_id,
      form_title: "Questions Title",
      form_fields: [
        {
          field_id: dynamic_id,
          questions_title: "Untitled Questions",
          questions_photo: "",
          questions_type: [
            { value: "shot_questions_1", name: "Short Answer" },
            { value: "paragraph_questions_2", name: "Paragraph" },
            { value: "multiple_questions_3", name: "Multiple Choice" },
            { value: "checkboxes_questions_4", name: "Checkboxes" },
            { value: "file_questions_5", name: "File Upload" },
          ],
          select_type: "multiple_questions_3",
          options: [
            {
              option_id: option_dy_id,
              input_name: "Option",
              input_photo: "",
              ans: false,
            },
          ],
          ans: [],
          points: 0,
          shouldDisable: true,
          ans_mode: false,
        },
      ],
    };
  },
  methods: {
    add_new_fields: function () {
      this.form_fields.push({
        field_id: ++this.dynamic_id,
        questions_title: "Untitled Questions",
        questions_photo: "",
        questions_type: [
          { value: "shot_questions_1", name: "Short Answer" },
          { value: "paragraph_questions_2", name: "Paragraph" },
          { value: "multiple_questions_3", name: "Multiple Choice" },
          { value: "checkboxes_questions_4", name: "Checkboxes" },
          { value: "file_questions_5", name: "File Upload" },
        ],
        select_type: "multiple_questions_3",
        options: [
          {
            option_id: ++this.option_dy_id,
            input_name: "Option",
            input_photo: "",
            ans: false,
          },
        ],
        ans: [],
        points: 0,
        shouldDisable: true,
        ans_mode: false,
      });
      // this.option_dy_id++;
    },
    addNewOption: function (fields) {
      this.form_fields[fields].options.push({
        option_id: ++this.option_dy_id,
        input_name: "Option",
        input_photo: "",
        ans: false,
      });
    },
    removeOption: function (fields, index, name) {
      this.form_fields[fields].options.splice(index, 1);
      if (this.form_fields[fields].ans.includes(name)) {
        var index = this.form_fields[fields].ans.indexOf(name);
        this.form_fields[fields].ans.splice(index, 1);
      }
    },
    fields_copy: function (fields) {
      let item = this.form_fields[fields];
      var options = this.form_fields[fields].options;
      var itemsCopy = [];
      itemsCopy = options.slice();
      for (var i = 0; i < itemsCopy.length; i++) {
        var obj = Object.assign({}, itemsCopy[i]);
        obj.option_id = ++this.option_dy_id;
        obj.input_name = obj.input_name;
        obj.input_photo = obj.input_photo;
        obj.ans = false;
        itemsCopy[i] = obj;
      }
      let clone = {
        field_id: ++this.dynamic_id,
        questions_title: item.questions_title,
        questions_photo: item.questions_photo,
        questions_type: [
          { value: "shot_questions_1", name: "Short Answer" },
          { value: "paragraph_questions_2", name: "Paragraph" },
          { value: "multiple_questions_3", name: "Multiple Choice" },
          { value: "checkboxes_questions_4", name: "Checkboxes" },
          { value: "file_questions_5", name: "File Upload" },
        ],
        select_type: item.select_type,
        options: [...itemsCopy],
        ans: [],
        points: item.points,
        shouldDisable: item.shouldDisable,
        ans_mode: false,
      };
      this.form_fields.splice(++fields, 0, clone);
      // this.form_fields.push(clone);
    },
    fields_delete: function (index) {
      this.form_fields.splice(index, 1);
    },
    set_answer: function (index) {
      this.form_fields[index].ans_mode = true;
    },
    ans_bind_click: function (main_index, option, name) {
      option.ans = !option.ans;
      if (option.ans) {
        this.form_fields[main_index].ans.push(name);
      } else {
        if (this.form_fields[main_index].ans.includes(name)) {
          var index = this.form_fields[main_index].ans.indexOf(name);
          this.form_fields[main_index].ans.splice(index, 1);
        }
      }
      // console.log(this.form_fields[main_index].ans);
    },
    done_answer: function (index) {
      this.form_fields[index].ans_mode = !this.form_fields[index].ans_mode;
    },
    clicked() {
      this.form_fields.shouldDisable = false;
    },
    // show_on_focus() {
    //   let el = document.getElementsByClassName("olm_ques_form_item")[0];
    //   // el.on('click', function () {
    //   //   this.
    //   // });
    // },
    ques_title_photo: function (event, main_index, option = "") {
      let file = event.target.files[0];
      let reader = new FileReader();
      if (file["size"] < 2111775) {
        reader.onloadend = (file) => {
          //console.log('RESULT', reader.result)
            this.form_fields[main_index].questions_photo = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        alert("File size can not be bigger than 2 MB");
      }
    },
    ans_option_photo: function (event, main_index, option = "") {
      let file = event.target.files[0];
      let reader = new FileReader();
      if (file["size"] < 2111775) {
        reader.onloadend = (file) => {
          this.form_fields[main_index].options[option].input_photo =
            reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        alert("File size can not be bigger than 2 MB");
      }
    },
    get_ques_title_photo: function (main_index, option = "") {
      let photo =
        this.form_fields[main_index].questions_photo.length > 100
          ? this.form_fields[main_index].questions_photo
          : "";

      return photo;
    },
    get_ans_option_photo: function (main_index, option = "") {
      let photo =
        this.form_fields[main_index].options[option].input_photo.length > 100
          ? this.form_fields[main_index].options[option].input_photo
          : "";

      return photo;
    },
    remove_title_photo: function (main_index, option = "") {
        this.form_fields[main_index].questions_photo = "";
    },
    remove_ans_option_photo: function (main_index, option = "") {
      this.form_fields[main_index].options[option].input_photo = "";
    },
    save_fields: function () {
      var form = $("form").serializeArray();
      // let formData = new FormData(document.getElementById('YOUR_FORM_ID'));
      // console.log(JSON.stringify(this.form_fields));
      // let formData = document.getElementById("olm_questions_form");
      // console.log(JSON.stringify(this.serializeObject().formData));
      console.log(JSON.stringify(this.form_fields));
      const formData = new FormData();

      // Add images to form data
      formData.append("title", this.form_title);
      formData.append("row_data", JSON.stringify(this.form_fields));

      // axios
      //   .post("get/data", formData)
      //   .then((response) => console.log(response.data));

      // console.log(JSON.stringify(this.form_fields));
    },
  },
  mounted() {
    window.addEventListener("beforeunload", this.leaving);
  },
};
</script>

<style scoped>
.item_show_on_expand input,
.item_show_on_expand .ql-editor,
.item_show_on_expand textarea {
  border: none;
  border-bottom: 1px solid #ddd;
}
.item_show_on_expand input:focus,
.item_show_on_expand textarea:focus {
  border: none;
  border-bottom: 1px solid #37a000;

  box-shadow: inset 0 1px 1px rgba(55, 160, 0, 0.075),
    0 0 20px rgba(55, 160, 0, 0.1);
}
.olm_ques_form_item .ql-editor:hover {
  border: none;
  border-bottom: 1px solid #37a000 !important;

  box-shadow: inset 0 1px 1px rgba(55, 160, 0, 0.075),
    0 0 20px rgba(55, 160, 0, 0.1);
}
.item_show_on_expand .option_remove {
  color: #ddd;
  font-size: 22px;
  transition: all 0.3s linear;
}
.item_show_on_expand .option_remove:hover {
  color: #dc3545;
}
.field_footer i {
  display: inline-block;
  font-size: 20px;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}
.field_footer .field_copy:hover {
  color: #37a000;
}
.field_footer .field_delete:hover {
  color: rgb(252, 65, 65);
}
.olm_ques_form_item .show_on_focus {
  display: none;
}
.olm_ques_form_item:hover .show_on_focus {
  display: block;
}
.olm_ques_item_head .ql-toolbar.ql-snow {
  display: none !important;
}
.olm_ques_form_item .ques_title_photo {
  position: absolute;
  top: -10px;
  left: -10px;
  cursor: pointer;
  font-size: 20px;
}
</style>
