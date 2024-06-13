<?php

namespace App\Http\Controllers\Api;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Throwable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Traits\AIContactFunctions;

class ExamController extends Controller
{
    use AIContactFunctions;
    // Tüm sınavları listele
    public function index()
    {
        $exams = Exam::all();
        return response()->json($exams);
    }

    // Yeni bir sınav oluştur
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_name' => 'nullable|string|max:255',
            // 'assistant_id' => 'required|string',
            'sinif_duzeyi' => 'required|string',
            'soru_sayisi' => 'required|string',
            'zorluk_seviyesi' => 'required|string',
            'konu' => 'required|string',
            // 'fields' => 'required|array',
            'status' => 'nullable|integer',
        ]);

        $user = auth()->user();

        DB::beginTransaction();
        try {
            $currentDateTime = Carbon::now();
            $formattedDateTime = $currentDateTime->format('dmYHis');
            $examAssistantName = "exam_" . strval($user->id) . "_" . $formattedDateTime;
            $api_key = $this->getApiKey();
            
            $instructions = "Sen bir yapay zeka asistanısın. Aşağıdaki talimatlara göre öğrencilere rehberlik edecek ve soruları soracaksın: \n\n1. Sınıf düzeyi: \"{$request->sinif_duzeyi}\" \n2. Konu: \"{$request->konu}\" \n3. Zorluk düzeyi: \"{$request->zorluk_duzeyi}\" \n4. Soru sayısı: {$request->soru_sayisi} \n\nÖğrencilerle şu şekilde etkileşimde bulun: \n- Soruları sırayla sor ve öğrencilere cevap vermeleri için zaman tanı. \n- Yanlış cevap veren öğrencileri motive et ve anlamadıkları konuları sohbet ederek açıkla. \n- Öğrencilerin motivasyonunu sürekli yüksek tut, her sorudan sonra onları cesaretlendirici sözler söyle. \n- Sorular arasında, öğrencinin yaşına uygun espriler yap veya bilmeceler sorarak eğlenceli bir ortam oluştur. \n\nBu ödevin adı: \"{$request->name}\" \n\nBaşla.";



            /* $instructions = "";
            $createInstructionsPrompt = "OpenAI üzerinden bir yapay zeka asistanı oluşturacağım. Bu asistanın \"talimatlar\" alanına yazabileceğim bir prompt yazmanı istiyorum. Gerekli bütün bilgileri aşağıda yazıyorum. \n\n Ben bir öğretmenim. Sınıf düzeyi \"{$request->sinif_duzeyi}\" olan öğrencilerime çözmesi için \"{$request->konu}\" konusunda ve zorluk düzeyi \"{$request->zorluk_duzeyi}\" olan toplam {$request->soru_sayisi} tane sorudan oluşan bir ödev vereceğim. \n\nÖğrencilerin bu ödevi yapay zeka ile sohbet ederek çözmeleri için bir yapay zeka asistanı oluşturacağım. Soruları, yapay zeka asistanı öğrencilere soracak. Bu asistanın talimatlarına yazılmak üzere bir prompt hazırla. \n\nÖdevin asıl amacı öğrencileri ölçüp puan vermek değil, ödevin konusuna tam anlamıyla hakim olmalarıdır. Öğrencilerin bir soruyu yanlış cevaplaması durumunda onu motive etsin ve öğrencinin anlamadığı/eksik kaldığı konuyu sohbet ederek öğretsin. Öğrencinin motivasyonunu sürekli yüksek tutsun. Soru aralarında, sınıf düzeyi \"{$request->sinif_duzeyi}\" olan bu öğrenciyi sıkmayacak şekilde, yaşına uygun espriler yap veya bilmece sor. \n\nBu ödevin ismi {$request->name} olacak. \n\nBahsettiğim yapay zeka asistanını oluşturacak promptu yaz.\n\nSadece promptu yaz. Prompt harici herhangi bir metin (selamlama, başlık, açıklama vs.) yazma. Promptu düz metin olarak yaz. Metni formatlama. Prompt harici hiçbir karakter ekleme.";
            $instructionsResponse = Http::withHeaders([
                "Authorization" => "Bearer " . $api_key->key,
                "Content-Type" => "application/json",
            ])
                ->withoutVerifying()
                ->timeout(999999)
                ->post("https://api.openai.com/v1/chat/completions", [
                    "messages" => [
                        [
                            "role" => "user",
                            "content" => $createInstructionsPrompt,
                        ],
                    ],
                    "model" => "gpt-4o",
                    "max_tokens" => 4000,
                    "temperature" => 0.1,
                ]);

            $messageListJson = $instructionsResponse->json();
            $messageListStatus = $instructionsResponse->status();

            // return response()->json([
            //     "json" => $messageListJson,
            // ]);
            if ($messageListStatus != 200 || !isset($messageListJson["choices"])) {
                return response()->json([
                    "message" => "Asistan oluşturulamadı!"
                ], 500);
            }
            $instructions = $messageListJson["choices"][0]["message"]["content"]; 

            return response()->json([
                "talimat" => $instructions,
            ]);*/



            $assistantResponse = Http::withHeaders([
                "Authorization" => "Bearer " . $api_key->key,
                "Content-Type" => "application/json",
                "OpenAI-Beta" => "assistants=v2"
            ])
                ->withoutVerifying()
                ->post("https://api.openai.com/v1/assistants", [
                    "instructions" => $instructions,
                    "name" => $examAssistantName,
                    "model" => "gpt-3.5-turbo",
                    "temperature" => 0.1,
                ]);

            $assistantJson = $assistantResponse->json();
            $assistantStatus = $assistantResponse->status();
            if ($assistantStatus != 200 || !isset($assistantJson["id"])) {
                return response()->json([
                    "message" => "Asistan oluşturulamadı!"
                ], 500);
            }
            $assistantId = $assistantJson["id"];

            $exam = Exam::create([
                'name' => $request->name,
                'image_name' => $request->image_name,
                'assistant_id' => $assistantId,
                'sinif_duzeyi' => $request->sinif_duzeyi,
                'soru_sayisi' => $request->soru_sayisi,
                'zorluk_seviyesi' => $request->zorluk_seviyesi,
                'konu' => $request->konu,
                'status' => $request->status ?? 1,
            ]);

            Db::commit();


            return response()->json([
                "message" => "İnteraktif ödev oluşturuldu",
                "data" => $exam->toArray(),
            ]);

        } catch (Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => __(
                        "Birşeyler yanlış gitti. Lütfen destek ekibi ile iletişime geçiniz. HATA:" .
                        $th
                    ),
                ],
                403
            );
        }
    }

    // Belirli bir sınavı göster
    public function show($id)
    {
        $exam = Exam::findOrFail($id);
        return response()->json($exam);
    }

    // Belirli bir sınavı güncelle
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'image_name' => 'nullable|string|max:255',
            'assistant_id' => 'sometimes|required|string',
            'sinif_duzeyi' => 'sometimes|required|string',
            'soru_sayisi' => 'sometimes|required|string',
            'zorluk_seviyesi' => 'sometimes|required|string',
            'konu' => 'sometimes|required|string',
            // 'fields' => 'sometimes|required|array',
            'status' => 'sometimes|nullable|integer',
        ]);

        $exam = Exam::findOrFail($id);
        $exam->update($request->all());

        return response()->json($exam);
    }

    // Belirli bir sınavı sil
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        return response()->json(null, 204);
    }
}
