<?php

namespace App\Http\Controllers\Admin;

use App\Models\MainMcq;
use App\Models\Subject;
use App\Models\McqAnswer;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helper\PhotoUploadTrait;
use App\Http\Controllers\Controller;

use function GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Auth;

class McqController extends Controller
{
    use PhotoUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_mcqs = MainMcq::orderBy('id', 'desc')->get();
        return view('admin.main_mcqs.index', compact('all_mcqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.main_mcqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $dynamic_id = [$request->dynamic_id, $request->option_dy_id];
        $title = $request->title;
        // $check_title = MainMcq::where('title', $title)->first();
        // if ($check_title) {
        //     return response()->json(['title_error' => 'Title already taken']);
        // }

        $row_datas = json_decode($request->row_data);
        $custom_row_data = [];

        foreach ($row_datas as $main_key =>  $item) {

            $custom_row_data[$main_key]['field_id'] = $item->field_id;
            $custom_row_data[$main_key]['questions_title'] = $item->questions_title;
            if ($item->questions_photo != '' && strlen($item->questions_photo) > 100) {
                $custom_row_data[$main_key]['questions_photo']  =   $this->Upload64Bit($item->questions_photo, 'images/questions', [], $item->field_id);
            } else {
                $custom_row_data[$main_key]['questions_photo']  = "";
            }
            $custom_row_data[$main_key]['questions_type'] = $item->questions_type;
            $custom_row_data[$main_key]['select_type'] = $item->select_type;
            if ($item->select_type == 'multiple_questions_3') {
                $custom_options = [];
                foreach ($item->options as $key => $option) {
                    if ($option->input_photo != '' && strlen($option->input_photo) > 100) {
                        $custom_options[$key]['option_id'] = $option->option_id;
                        $custom_options[$key]['input_name'] = $option->input_name;
                        $custom_options[$key]['input_photo'] = $this->Upload64Bit($option->input_photo, 'images/questions/answer', [], $option->option_id . '_' . $item->field_id);
                        $custom_options[$key]['ans'] = $option->ans;
                        // echo $this->Upload64Bit($option->input_photo, 'images/questions/answer', [], $option->option_id);
                    } else {
                        if ($option->input_photo == '') {
                            $link1 = base_path('public/images/questions/answer/' . $option->option_id . '_' . $item->field_id . '.jpg');
                            $link2 = base_path('public/images/questions/answer/' . $option->option_id . '_' . $item->field_id . '.png');
                            $link3 = base_path('public/images/questions/answer/' . $option->option_id . '_' . $item->field_id . '.jpeg');
                            $link4 = base_path('public/images/questions/answer/' . $option->option_id . '_' . $item->field_id . '.gif');
                            if (file_exists($link1)) {
                                unlink($link1);
                            }
                            if (file_exists($link2)) {
                                unlink($link2);
                            }
                            if (file_exists($link3)) {
                                unlink($link3);
                            }
                            if (file_exists($link4)) {
                                unlink($link4);
                            }
                        }
                        $custom_options[$key]['option_id'] = $option->option_id;
                        $custom_options[$key]['input_name'] = $option->input_name;
                        $custom_options[$key]['input_photo'] = $option->input_photo;
                        $custom_options[$key]['ans'] = $option->ans;
                    }
                }
                $custom_row_data[$main_key]['options'] = $custom_options;
            } else {
                $custom_row_data[$main_key]['options'] = $item->options;
            }
            $custom_row_data[$main_key]['ans'] = $item->ans;
            $custom_row_data[$main_key]['points'] = $item->points;
            $custom_row_data[$main_key]['shouldDisable'] = $item->shouldDisable;
            $custom_row_data[$main_key]['ans_mode'] = $item->ans_mode;
            $custom_row_data[$main_key]['answer_review'] = $item->answer_review;
        }
        $row_array = $custom_row_data;
        $row_mcq = json_encode($custom_row_data);
        $dynamic_id = implode('||', $dynamic_id);
        $crate_mcq = new MainMcq();
        $crate_mcq->user_id = Auth::id();
        $crate_mcq->sl = $request->sl;
        $crate_mcq->title = $title;
        $crate_mcq->time = $request->time;
        $crate_mcq->dynamic_id = $dynamic_id;
        $crate_mcq->row_mcq = $row_mcq;
        $crate_mcq->optional = $request->video;
        $crate_mcq->subject_id = $request->subject_id;
        $crate_mcq->save();
        foreach ($row_array as $item) {
            $options = [];
            $options_id = [];
            if ($item['select_type'] == 'multiple_questions_3') {
                foreach ($item['options'] as $option) {
                    array_push($options, $option['input_name']);
                    array_push($options_id, $option['option_id']);
                }
            }
            $mcq_ans = new McqAnswer();
            $mcq_ans->main_mcq_id = $crate_mcq->id;
            $mcq_ans->sl = $request->sl;
            $mcq_ans->question_id = $item['field_id'];
            $mcq_ans->questions_title = $item['questions_title'];
            $mcq_ans->questions_type = $item['select_type'];
            $mcq_ans->options = $item['select_type'] == 'multiple_questions_3' ? implode('||', $options) : '';
            $mcq_ans->options_id = $item['select_type'] == 'multiple_questions_3' ? implode('||', $options_id) : '';
            $mcq_ans->answers = $item['ans'];
            $mcq_ans->answer_points = $item['points'];
            $mcq_ans->answer_review = $item['answer_review'];
            $mcq_ans->save();
        }
        return response()->json(['success' => 'Data crated successfully']);

        // if ($crate_mcq) {
        //     return redirect()->json(['success' => 'Data crated successfully']);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mcq = MainMcq::find($id);
        if (!$mcq) {
            return back();
        }
        return view('admin.main_mcqs.show', compact('mcq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mcq = MainMcq::find($id);
        if ($mcq) {
            return view('admin.main_mcqs.edit', compact('mcq'));
        } else {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dynamic_id = [$request->dynamic_id, $request->option_dy_id];
        $title = $request->title;
        // $check_title = MainMcq::where('title', $title)->where('id', '!=', $id)->first();
        // if ($check_title) {
        //     return response()->json(['title_error' => 'Title already taken']);
        // }
        $row_datas = json_decode($request->row_data);
        $custom_row_data = [];
        foreach ($row_datas as $main_key =>  $item) {

            $custom_row_data[$main_key]['field_id'] = $item->field_id;
            $custom_row_data[$main_key]['questions_title'] = $item->questions_title;
            if ($item->questions_photo != '' && strlen($item->questions_photo) > 100) {
                $custom_row_data[$main_key]['questions_photo']  =   $this->Upload64Bit($item->questions_photo, 'images/questions', [], $item->field_id);
            } else {
                $custom_row_data[$main_key]['questions_photo'] = $item->questions_photo;
                if ($item->questions_photo == '') {
                    $link1 = base_path('public/images/questions/' . $item->field_id . '.jpg');
                    $link2 = base_path('public/images/questions/' . $item->field_id . '.png');
                    $link3 = base_path('public/images/questions/' . $item->field_id . '.jpeg');
                    $link4 = base_path('public/images/questions/' . $item->field_id . '.gif');
                    if (file_exists($link1)) {
                        unlink($link1);
                    }
                    if (file_exists($link2)) {
                        unlink($link2);
                    }
                    if (file_exists($link3)) {
                        unlink($link3);
                    }
                    if (file_exists($link4)) {
                        unlink($link4);
                    }
                }
            }
            $custom_row_data[$main_key]['questions_type'] = $item->questions_type;
            $custom_row_data[$main_key]['select_type'] = $item->select_type;
            if ($item->select_type == 'multiple_questions_3') {
                $custom_options = [];
                foreach ($item->options as $key => $option) {
                    if ($option->input_photo != '' && strlen($option->input_photo) > 100) {
                        $custom_options[$key]['option_id'] = $option->option_id;
                        $custom_options[$key]['input_name'] = $option->input_name;
                        $custom_options[$key]['input_photo'] = $this->Upload64Bit($option->input_photo, 'images/questions/answer', [], $option->option_id . '_' . $item->field_id);
                        $custom_options[$key]['ans'] = $option->ans;
                        // echo $this->Upload64Bit($option->input_photo, 'images/questions/answer', [], $option->option_id);
                    } else {
                        if ($option->input_photo == '') {
                            $link1 = base_path('public/images/questions/answer/' . $option->option_id . '_' . $item->field_id . '.jpg');
                            $link2 = base_path('public/images/questions/answer/' . $option->option_id . '_' . $item->field_id . '.png');
                            $link3 = base_path('public/images/questions/answer/' . $option->option_id . '_' . $item->field_id . '.jpeg');
                            $link4 = base_path('public/images/questions/answer/' . $option->option_id . '_' . $item->field_id . '.gif');
                            if (file_exists($link1)) {
                                unlink($link1);
                            }
                            if (file_exists($link2)) {
                                unlink($link2);
                            }
                            if (file_exists($link3)) {
                                unlink($link3);
                            }
                            if (file_exists($link4)) {
                                unlink($link4);
                            }
                        }
                        $custom_options[$key]['option_id'] = $option->option_id;
                        $custom_options[$key]['input_name'] = $option->input_name;
                        $custom_options[$key]['input_photo'] = $option->input_photo;
                        $custom_options[$key]['ans'] = $option->ans;
                    }
                }
                $custom_row_data[$main_key]['options'] = $custom_options;
            } else {
                $custom_row_data[$main_key]['options'] = $item->options;
            }
            $custom_row_data[$main_key]['ans'] = $item->ans;
            $custom_row_data[$main_key]['points'] = $item->points;
            $custom_row_data[$main_key]['shouldDisable'] = $item->shouldDisable;
            $custom_row_data[$main_key]['ans_mode'] = $item->ans_mode;
            if (!empty($item->answer_review)) {
                $custom_row_data[$main_key]['answer_review'] = $item->answer_review;
            }
        }

        $row_array = $custom_row_data;

        $row_mcq = json_encode($custom_row_data);
        // return $row_mcq;
        // $html = htmlentities($row_mcq);
        $dynamic_id = implode('||', $dynamic_id);
        $update_mcq =  MainMcq::find($id);
        $update_mcq->user_id = Auth::id();
        $update_mcq->sl = $request->sl;
        $update_mcq->title = $title;
        $update_mcq->time = $request->time;
        $update_mcq->dynamic_id = $dynamic_id;
        $update_mcq->row_mcq = $row_mcq;
        $update_mcq->optional = $request->video;
        $update_mcq->subject_id = $request->subject_id;
        $update_mcq->save();

        $ans = McqAnswer::where('main_mcq_id', $id)->where('sl', $request->sl)->pluck('id');
        $i = 0;
        foreach ($row_array as $item) {

            $options = [];
            $options_id = [];
            if ($item['select_type'] == 'multiple_questions_3') {
                foreach ($item['options'] as $option) {
                    array_push($options, $option['input_name']);
                    array_push($options_id, $option['option_id']);
                }
            }
            if (count($ans) > $i) {
                if ($item['select_type'] != 'only_paragraph_5') {
                    $mcq_ans = McqAnswer::find($ans[$i]);
                    $mcq_ans->main_mcq_id = $update_mcq->id;
                    $mcq_ans->sl = $request->sl;
                    $mcq_ans->question_id = $item['field_id'];
                    $mcq_ans->questions_title = $item['questions_title'];
                    $mcq_ans->questions_type = $item['select_type'];
                    $mcq_ans->options = $item['select_type'] == 'multiple_questions_3' ? implode('||', $options) : '';
                    $mcq_ans->options_id = $item['select_type'] == 'multiple_questions_3' ? implode('||', $options_id) : '';
                    $mcq_ans->answers = $item['ans'];
                    $mcq_ans->answer_points = $item['points'];
                    $mcq_ans->answer_review = array_key_exists('answer_review', $item) ? $item['answer_review'] : '';
                    $mcq_ans->save();
                }
            } else {
                if ($item['select_type'] != 'only_paragraph_5') {
                    $mcq_ans = new McqAnswer();
                    $mcq_ans->main_mcq_id = $update_mcq->id;
                    $mcq_ans->sl = $request->sl;
                    $mcq_ans->question_id = $item['field_id'];
                    $mcq_ans->questions_title = $item['questions_title'];
                    $mcq_ans->questions_type = $item['select_type'];
                    $mcq_ans->options = $item['select_type'] == 'multiple_questions_3' ? implode('||', $options) : '';
                    $mcq_ans->options_id = $item['select_type'] == 'multiple_questions_3' ? implode('||', $options_id) : '';
                    $mcq_ans->answers = $item['ans'];
                    $mcq_ans->answer_points = $item['points'];
                    $mcq_ans->answer_review = array_key_exists('answer_review', $item) ? $item['answer_review'] : '';
                    $mcq_ans->save();
                }
            }
            $i++;
        }
        return response()->json(['success' => 'Data crated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = MainMcq::findOrFail($id);
        $destroy->delete();
        // $link = base_path('public/video/' . $destroy->video);
        // if (file_exists($link)) {
        //     unlink($link);
        // }

        return redirect()->route('admin.main-mcqs.index')->with('success', 'Data is successfully deleted');
    }

    public function check_title(Request $request)
    {
        $check_title = MainMcq::where('title', $request->title)->first();
        if ($check_title) {
            return response()->json(['error' => 'Title already taken']);
        } else {
            return response()->json(['success' => 'okay']);
        }
    }
    public function ajax_subject(Request $request)
    {
        $subjects = Subject::orderBy('id', 'desc')->get();
        $option = '<option value="">Select</option>';
        foreach ($subjects as $subject) {
            $option .= '<option value="' . $subject->id . '">' . $subject->name . '</option>';
        }

        return response(Subject::orderBy('id', 'desc')->get()->jsonSerialize(), Response::HTTP_OK);
    }
}
