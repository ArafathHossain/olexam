<?php

namespace App\Http\Controllers\Admin;

use Cart;
use App\Models\User;
use App\Models\Enroll;
use App\Models\MainMcq;
use App\Models\McqAnswer;
use Illuminate\Http\Request;
use App\Models\McqUserAnswer;
use App\Helper\PhotoUploadTrait;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    use PhotoUploadTrait;

    // public function __construct()
    // {
    //     $this->middleware('permission:manage-posts', ['only' => ['file_content']]);
    // }
    public function index()
    {
        return view('admin.test.index');
    }

    public function file_content()
    {
        //     return 'sdfsdf';
        //     $row_data = '[{"field_id":567,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"checkboxes_questions_4","name":"Checkboxes"},{"value":"file_questions_5","name":"File Upload"}],"select_type":"multiple_questions_3","options":[{"option_id":567,"input_name":"Option","input_photo":"","ans":false},{"option_id":568,"input_name":"Option","input_photo":"","ans":false},{"option_id":569,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":0,"shouldDisable":true,"ans_mode":false},{"field_id":568,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"checkboxes_questions_4","name":"Checkboxes"},{"value":"file_questions_5","name":"File Upload"}],"select_type":"shot_questions_1","options":[{"option_id":570,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":0,"shouldDisable":true,"ans_mode":false}]';
        //     $json_de = json_decode($row_data);

        //     $custom_row_data = [];
        //     $custom_options = [];
        //     foreach ($json_de as $main_key =>  $item) {
        //         $custom_row_data[$main_key]['field_id'] = $item->field_id;
        //         $custom_row_data[$main_key]['questions_title'] = $item->questions_title;
        //         if ($item->questions_photo != '' && strlen($item->questions_photo) > 100) {
        //             $custom_row_data[$main_key]['questions_photo']  =   $this->Upload64Bit($item->questions_photo, 'images/questions', [], $item->field_id);
        //         } else {
        //             if ($item->questions_photo == '') {
        //                 $link1 = base_path('public/images/questions/' . $item->field_id . '.jpg');
        //                 $link2 = base_path('public/images/questions/' . $item->field_id . '.png');
        //                 $link3 = base_path('public/images/questions/' . $item->field_id . '.jpeg');
        //                 $link4 = base_path('public/images/questions/' . $item->field_id . '.gif');
        //                 if (file_exists($link1)) {
        //                     unlink($link1);
        //                 }
        //                 if (file_exists($link2)) {
        //                     unlink($link2);
        //                 }
        //                 if (file_exists($link3)) {
        //                     unlink($link3);
        //                 }
        //                 if (file_exists($link4)) {
        //                     unlink($link4);
        //                 }
        //             }
        //             $custom_row_data[$main_key]['questions_photo']  = "";
        //         }
        //         $custom_row_data[$main_key]['questions_type'] = $item->questions_type;
        //         $custom_row_data[$main_key]['select_type'] = $item->select_type;
        //         if ($item->select_type == 'multiple_questions_3') {
        //             foreach ($item->options as $key => $option) {
        //                 if ($option->input_photo != '' && strlen($option->input_photo) > 100) {
        //                     $custom_options[$key]['option_id'] = $option->option_id;
        //                     $custom_options[$key]['input_name'] = $option->input_name;
        //                     $custom_options[$key]['input_photo'] = $this->Upload64Bit($option->input_photo, 'images/questions/answer', [], $option->option_id);
        //                     $custom_options[$key]['ans'] = $option->ans;
        //                     // echo $this->Upload64Bit($option->input_photo, 'images/questions/answer', [], $option->option_id);
        //                 } else {
        //                     if ($option->input_photo == '') {
        //                         $link1 = base_path('public/images/questions/answer/' . $item->field_id . '.jpg');
        //                         $link2 = base_path('public/images/questions/answer/' . $item->field_id . '.png');
        //                         $link3 = base_path('public/images/questions/answer/' . $item->field_id . '.jpeg');
        //                         $link4 = base_path('public/images/questions/answer/' . $item->field_id . '.gif');
        //                         if (file_exists($link1)) {
        //                             unlink($link1);
        //                         }
        //                         if (file_exists($link2)) {
        //                             unlink($link2);
        //                         }
        //                         if (file_exists($link3)) {
        //                             unlink($link3);
        //                         }
        //                         if (file_exists($link4)) {
        //                             unlink($link4);
        //                         }
        //                     }
        //                     $custom_options[$key]['option_id'] = $option->option_id;
        //                     $custom_options[$key]['input_name'] = $option->input_name;
        //                     $custom_options[$key]['input_photo'] = $option->input_photo;
        //                     $custom_options[$key]['ans'] = $option->ans;
        //                 }
        //             }
        //             $custom_row_data[$main_key]['options'] = $custom_options;
        //         } else {
        //             $custom_row_data[$main_key]['options'] = $item->options;
        //         }
        //         $custom_row_data[$main_key]['ans'] = $item->ans;
        //         $custom_row_data[$main_key]['points'] = $item->points;
        //         $custom_row_data[$main_key]['shouldDisable'] = $item->shouldDisable;
        //         $custom_row_data[$main_key]['ans_mode'] = $item->ans_mode;
        //     }
        //     return json_encode($custom_row_data);
        // explode('/', explode(':', substr($request->avatar, 0, strpos($request->avatar, ';')))[1])[1]

        // $row = '[{"field_id":37008,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"multiple_questions_3","options":[{"option_id":96734,"input_name":"Option","input_photo":"","ans":true},{"option_id":96735,"input_name":"Option","input_photo":"","ans":false},{"option_id":96736,"input_name":"Option","input_photo":"","ans":false},{"option_id":96737,"input_name":"Option","input_photo":"","ans":false}],"ans":["ans_96734_opt_37008"],"points":"2","shouldDisable":true,"ans_mode":false},{"field_id":37009,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"multiple_questions_3","options":[{"option_id":96738,"input_name":"Option","input_photo":"","ans":false},{"option_id":96739,"input_name":"Option","input_photo":"","ans":false},{"option_id":96740,"input_name":"Option","input_photo":"","ans":false},{"option_id":96741,"input_name":"Option","input_photo":"","ans":true}],"ans":["ans_96741_opt_37009"],"points":"2","shouldDisable":true,"ans_mode":false},{"field_id":37011,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"shot_questions_1","options":[{"option_id":96746,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":"2","shouldDisable":true,"ans_mode":false},{"field_id":37012,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"paragraph_questions_2","options":[{"option_id":96747,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":"4","shouldDisable":true,"ans_mode":false},{"field_id":37013,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"file_questions_4","options":[{"option_id":96748,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":"4","shouldDisable":true,"ans_mode":false},{"field_id":37014,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"multiple_questions_3","options":[{"option_id":96749,"input_name":"Option","input_photo":"","ans":false},{"option_id":96750,"input_name":"Option","input_photo":"","ans":false},{"option_id":96751,"input_name":"Option","input_photo":"","ans":false},{"option_id":96752,"input_name":"Option","input_photo":"","ans":true}],"ans":["ans_96752_opt_37014"],"points":"2","shouldDisable":true,"ans_mode":false}]';
        // $custom_row_data = json_decode($row);
        // $ans = McqAnswer::where('sl', 'MCQ-5799131')->pluck('id');
        // $i = 0;
        // foreach ($custom_row_data as $item) {
        //     if (count($ans) > $i) {
        //         $mcq_ans = McqAnswer::find($ans[$i]);
        //         $mcq_ans->sl = 'MCQ-5799131';
        //         $mcq_ans->question_id = $item->field_id;
        //         $mcq_ans->questions_type = $item->select_type;
        //         $mcq_ans->answers = implode('||', $item->ans);
        //         $mcq_ans->answer_points = $item->points;
        //         $mcq_ans->save();
        //     } else {
        //         $mcq_ans = new McqAnswer();
        //         $mcq_ans->sl = 'MCQ-5799131';
        //         $mcq_ans->question_id = $item->field_id;
        //         $mcq_ans->questions_type = $item->select_type;
        //         $mcq_ans->answers = implode('||', $item->ans);
        //         $mcq_ans->answer_points = $item->points;
        //         $mcq_ans->save();
        //     }
        //     $i++;
        // }
    }
    public function get_data(Request $request)
    {
        $mcq = McqAnswer::where('sl', $request->mcq_sl)->where('questions_type', '!=', 'only_paragraph_5')->get();
        $has_ans = McqUserAnswer::where('main_mcq_id', $request->mcq_id)->where('user_id', auth()->id())->get();
        if ($mcq) {
            foreach ($mcq as $mc) {
                foreach ($request->all() as $k => $item) {
                    if ($mc->question_id == $k) {
                        if (is_array($item)) {
                            $correct_ans = explode("||", $mc->answers);
                            sort($item);
                            sort($correct_ans);
                            if (count($has_ans) <= 0) {
                                $mcq_ans = new McqUserAnswer();
                                $mcq_ans->user_id = auth()->id();
                                $mcq_ans->main_mcq_id = $request->mcq_id;
                                $mcq_ans->sl = $request->mcq_sl;
                                $mcq_ans->question_id = $k;
                                $mcq_ans->questions_type = $mc->questions_type;
                                $mcq_ans->answers = implode('||', $item);
                                $mcq_ans->points = ($item == $correct_ans) ? $mc->answer_points : 0;
                                $mcq_ans->save();
                            }
                        } else {
                            if (count($has_ans) <= 0) {
                                $mcq_ans = new McqUserAnswer();
                                $mcq_ans->user_id = auth()->id();
                                $mcq_ans->main_mcq_id = $request->mcq_id;
                                $mcq_ans->sl = $request->mcq_sl;
                                $mcq_ans->question_id = $k;
                                $mcq_ans->questions_type = $mc->questions_type;
                                $mcq_ans->answers = $item;
                                $mcq_ans->points = (!empty($item)) ? (($item == $mc->answers) ? $mc->answer_points : 0) : 0;
                                $mcq_ans->save();
                            }
                        }
                    }
                }
            }
        }
    }
}
