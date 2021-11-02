<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 mx-auto">
        <div class="olm_questions_form">
          <div class="card p-3 shadow">
          <div class="row">
            <div class="col-md-3">
              <label for="">MCQ SL#</label>
              <input
                type="text"
                class="form-control"
                readonly
                :value="this.sl"
              />
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="">Time</label>
                <input
                  type="text"
                  class="form-control"
                  name=""
                  v-model="time"
                />
                <span
                  v-if="time_error"
                  class="text-danger d-inline-block mt-2"
                  >{{ time_error }}</span
                >
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="">Question Set Title</label>
                <input
                  type="text"
                  class="form-control"
                  name=""
                  v-model="form_title"
                />
                <span
                  v-if="title_error"
                  class="text-danger d-inline-block mt-2"
                  >{{ title_error }}</span
                >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Video</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="video"
                  placeholder="https://www.youtube.com/example"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Select Subject</label>
                <select class="form-control" v-model="subject_id">
                  <option value="">Select</option>
                  <option v-for="sub in subjects" :value="sub.id" :key="sub.id">
                    {{ sub.name }}
                  </option>
                </select>
                <span class="text-danger" v-if="subject_error != ''">{{
                  subject_error
                }}</span>
              </div>
            </div>
          </div>
          </div>
          <hr>
          <div
            class="olm_ques_form_item"
            v-for="(fields, main_index) in form_fields"
            :key="main_index"
          >
            <div class="card shadow">
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
                        <!-- <input
                          type="hidden"
                          :name="`ques_${fields.field_id}_title`"
                          :value="fields.questions_title"
                        /> -->
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

                    <div class="col-md-1">
                      <div v-if="!fields.questions_photo">
                          <input
                            type="file"
                            :id="`ques_${fields.field_id}_photo`"
                            class="custom-input-file"
                            :on="fields.questions_photo"
                            @change="ques_title_photo($event, main_index)"
                          />
                          <label :for="`ques_${fields.field_id}_photo`">
                            <i class="fas fa-image zoom"></i>
                          </label>
                        </div>
                    </div>

                    <div class="col-md-2">
                      <div class="form-group">
                        <select
                          class="form-control"
                          :id="`ques_${fields.field_id}_type`"
                          v-model="fields.select_type" style="width: 120%; margin-left: -20px;"
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
                  v-if="fields.select_type == 'multiple_questions_3'"
                >
                  <div
                    class="item_show_on_expand"
                    data-id=""
                    v-for="(option, index) in fields.options"
                    :key="index"
                  >
                    <div class="row align-items-center">

                      <div class="col-md-10">
                        <div
                          class="form-group option_item d-flex align-items-center"
                        >
                          <input
                            type="text"
                            class="form-control"
                            v-model="option.input_name"
                            :readonly="fields.ans_mode"
                            @click="
                              fields.ans_mode
                                ? ans_bind_click(
                                    main_index,
                                    option,
                                    option.option_id
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
                      
                      <div class="col-md-1">
                        <div v-if="fields.ans_mode == false">
                          <div v-if="!option.input_photo">
                            <input
                              type="file"
                              :id="`ans_${option.option_id}_opt_photo_${fields.field_id}`"
                              class="custom-input-file"
                              @change="
                                ans_option_photo($event, main_index, index)
                              "
                            />
                            <label
                              :for="`ans_${option.option_id}_opt_photo_${fields.field_id}`"
                            >
                              <i class="fas fa-image zoom"></i>
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
                      <div class="col-md-1">
                      <div
                        class="col-md-2 text-right"
                        v-show="index != 0"
                        v-if="fields.ans_mode == false"
                      >
                        <span
                          class="btn option_remove show_on_focus"
                          @click="
                            removeOption(main_index, index, option.option_id)
                          "
                        >
                          <i class="fas fa-times"></i>
                        </span>
                      </div>
                      </div>
                      <div class="col-md-1">
                        
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
                      <i class="fas fa-plus mr-1"></i> Add New Option
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
                            placeholder="Short answer multiple separate by ||"
                            v-model="fields.ans"
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
                            v-model="fields.ans"
                            rows="2"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="item_show_content"
                  v-if="fields.select_type == 'file_questions_4'"
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
                <div
                  class="item_show_content"
                  v-if="fields.select_type == 'only_paragraph_5'"
                >
                  <div class="item_show_on_expand">
                    <div class="row align-items-center">
                      <div class="col-md-8">
                        <div>Descriptions for Questions</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer show_on_focus pl-0">
                  <div class="form-group">
                    <!-- <textarea
                      class="form-control"
                      v-model="fields.answer_review"
                      name="answer_review"
                      rows="1"
                      placeholder="Set Answer Review"
                    ></textarea> -->
                    <quill-editor
                      v-model="fields.answer_review"
                      :options="editorLink"
                    />
                  </div>
                  <div class="row">
                    <div class="col-md-4 mr-auto">
                      <div
                        class="d-flex align-items-center"
                        v-if="fields.select_type != 'only_paragraph_5'"
                      >
                        <div
                          @click="set_answer(main_index)"
                          v-if="fields.select_type == 'multiple_questions_3'"
                        >
                          <span class="btn btn-info">Set Answer</span>
                        </div>
                        <span class="ml-3 d-flex align-items-center">
                          <span> {{ fields.points }} points </span>
                          <span
                            v-if="fields.select_type !== 'multiple_questions_3'"
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
          <hr>
          <div class="col-md-8 mx-auto text-center pt-2">
            <button
              type="submit"
              class="btn btn-success mx-auto sm"
              @click="save_fields"
            >
              <i class="fas fa-plus mr-1"></i> Save
            </button>
            <span>
              <b>Total Questions: ( {{ form_fields.length }} )</b>
            </span>
            <span
              ><b>Total Points: ( {{ this.totalAmount() }} )</b></span
            >
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <button
          class="btn btn-success w-100p add_new_field_btn"
          @click="add_new_fields"
        >
          <i class="fas fa-plus mr-2"></i>Add New Question
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
    let dynamic_id = Math.floor(Math.random() * (100000 - 1 + 1)) + 1;
    let option_dy_id = Math.floor(Math.random() * (100000 - 1 + 1)) + 1;
    return {
      editorOption: {
        modules: {
          toolbar: [
            [{ header: [1, 2, 3, 4, false] }],
            ["bold", "italic", "underline"],
            [{ script: "sub" }, { script: "super" }],
            ["image", "code-block", "link"],
            [{ align: [] }],
            [{ color: [] }, { background: [] }],
            [{ list: "ordered" }, { list: "bullet" }],
            [{ font: [] }],
          ],
        },
      },
      editorLink: {
        modules: {
          toolbar: [["link"]],
        },
        placeholder: "Set Answer Review",
      },
      base_url: window.location.origin,
      sl: "MCQ-" + Math.floor(Math.random() * (1000000000 - 1 + 1)) + 1,
      title_error: "",
      subject_error: "",
      time_error: "",
      dynamic_id: dynamic_id,
      option_dy_id: option_dy_id,
      form_title: "Question Set Title",
      time: "",
      video: "",
      subject_id: "",
      subjects: "",
      form_fields: [
        {
          field_id: dynamic_id,
          questions_title: "Untitled Questions",
          questions_photo: "",
          questions_type: [
            { value: "shot_questions_1", name: "Short Answer" },
            { value: "paragraph_questions_2", name: "Paragraph" },
            { value: "multiple_questions_3", name: "Multiple Choice" },

            { value: "only_paragraph_5", name: "Description" },
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
          ans: "",
          points: 0,
          shouldDisable: true,
          ans_mode: false,
          answer_review: "",
        },
      ],
    };
  },
  methods: {
    totalAmount: function () {
      return this.form_fields.reduce(
        (acc, item) => parseInt(acc) + parseInt(item.points),
        0
      );
    },
    add_new_fields: function () {
      this.form_fields.push({
        field_id: ++this.dynamic_id,
        questions_title: "Untitled Questions",
        questions_photo: "",
        questions_type: [
          { value: "shot_questions_1", name: "Short Answer" },
          { value: "paragraph_questions_2", name: "Paragraph" },
          { value: "multiple_questions_3", name: "Multiple Choice" },

          { value: "only_paragraph_5", name: "Description" },
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
        ans: "",
        points: 0,
        shouldDisable: true,
        ans_mode: false,
        answer_review: "",
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
      if (this.form_fields[fields].ans == name) {
        this.form_fields[fields].ans = "";
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

          { value: "only_paragraph_5", name: "Description" },
        ],
        select_type: item.select_type,
        options: [...itemsCopy],
        ans: "",
        points: item.points,
        shouldDisable: item.shouldDisable,
        ans_mode: false,
        answer_review: "",
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
    ans_bind_click: function (main_index, option, ans) {
      option.ans = !option.ans;
      if (option.ans) {
        this.form_fields[main_index].ans = ans;
      } else {
        this.form_fields[main_index].ans = "";
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
      if (file["size"] < 2 * 1024 * 1024) {
        reader.onloadend = (file) => {
          //console.log('RESULT', reader.result)
          this.form_fields[main_index].questions_photo = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        this.form_fields[main_index].questions_photo = "";
        alert("File size can not be bigger than 2 MB");
      }
    },
    ans_option_photo: function (event, main_index, option = "") {
      let file = event.target.files[0];
      let reader = new FileReader();
      if (file["size"] < 2 * 1024 * 1024) {
        reader.onloadend = (file) => {
          this.form_fields[main_index].options[option].input_photo =
            reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        this.form_fields[main_index].options[option].input_photo = "";
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
    check_unique_title: function () {
      // let base_url = window.location.origin;
      const formData = new FormData();
      formData.append("title", this.form_title);
      axios
        .post(this.base_url + "/admin/ajax-title/main-mcqs", formData)
        .then((response) => {
          if (response.data.error) {
            this.title_error = response.data.error;
          }
          if (response.data.success) {
            this.title_error = "";
          }
        });
    },
    save_fields: function () {
      if (this.subject_id == "") {
        this.subject_error = "Please select a subject!";
        return;
      }
      if (this.time == "") {
        this.time_error = "Please entry time!";
        return;
      }

      // Add images to form data
      const formData = new FormData();
      formData.append("sl", this.sl);
      formData.append("dynamic_id", this.dynamic_id);
      formData.append("option_dy_id", this.option_dy_id);
      formData.append("title", this.form_title);
      formData.append("time", this.time);
      formData.append("video", this.video);
      formData.append("subject_id", this.subject_id);
      formData.append("row_data", JSON.stringify(this.form_fields));
      axios
        .post(this.base_url + "/admin/main-mcqs", formData)
        .then((response) => {
          if (response.data.title_error) {
            this.title_error = response.data.title_error;
          }
          if (response.data.success) {
            window.location.href = this.base_url + "/admin/main-mcqs";
          }
        });

      // console.log(JSON.stringify(this.form_fields));
    },

    ajax_subject: function () {
      axios.get(this.base_url + "/admin/ajax/subject").then((response) => {
        this.subjects = response.data;
      });
    },
  },
  mounted() {
    const formData = new FormData();
    formData.append("sl", this.sl);
    axios
      .post(this.base_url + "/admin/ajax-title/main-mcqs", formData)
      .then((response) => {
        if (response.data.error) {
          this.sl = "MCQ-" + Math.floor(Math.random() * (1000000 - 1 + 1)) + 1;
        }
      });

    this.ajax_subject();
  },
};
</script>

<style scoped>

.add_new_field_btn {
  position: fixed;
  top: 50vh;
}
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

.olm_ques_form_item{
  margin-bottom: 60px;  
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

.shadow{
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}
.zoom {
  zoom: 270%;
  margin-left: -7px;
}
.ql-editor{
      height: 150px;
}
</style>
