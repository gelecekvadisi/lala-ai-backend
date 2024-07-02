<?php

namespace App\Http\Controllers\Api;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Traits\AIContactFunctions;
use App\Services\GoogleSheetsService;

class ExamController extends Controller
{
    use AIContactFunctions;

    protected GoogleSheetsService $googleSheetsService;
    private String $tableName = "Ödev Çözümleri";

    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

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
            $examSpreadsheetName = "{$request->name} - " . Str::uuid();
            $api_key = $this->getApiKey();

            $instructions = "Sen bir yapay zeka asistanısın. Aşağıdaki talimatlara göre öğrencilere rehberlik edecek ve soruları soracaksın: \n\n1. Sınıf düzeyi: \"{$request->sinif_duzeyi}\" \n2. Konu: \"{$request->konu}\" \n3. Zorluk düzeyi: \"{$request->zorluk_duzeyi}\" \n4. Soru sayısı: {$request->soru_sayisi} \n\nÖğrencilerle şu şekilde etkileşimde bulun: \n- Soruları sırayla sor ve öğrencilere cevap vermeleri için zaman tanı. \n- Yanlış cevap veren öğrencileri motive et ve anlamadıkları konuları sohbet ederek açıkla. \n- Öğrencilerin motivasyonunu sürekli yüksek tut, her sorudan sonra onları cesaretlendirici sözler söyle. \n- Sorular arasında, öğrencinin yaşına uygun espriler yap veya bilmeceler sorarak eğlenceli bir ortam oluştur. Öğrenciye sorduğun bilmecelerin cevabını yazmasını bekle. Asla öğrencinin moralini/motivasyonunu düşürecek sözler söyleme. \n\nÖğrenci bütün soruları bitirmelidir. Bütün soruları cevaplandırmadan ödev bitirilmez. \n\nBu ödevin adı: \"{$request->name}\" \n\nBaşla.";



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


            $email = "gelecekvadisiorg@gmail.com";
            $spreadsheetId = $this->googleSheetsService->createSpreadsheet($examSpreadsheetName);
            $this->googleSheetsService->setSpreadsheetId($spreadsheetId);
            // $this->googleSheetsService->appendRow("'{$this->tableName}'!A1", [[
            $this->googleSheetsService->appendRow("A1", [[
                "Tamamlanma Zamanı",
                "Toplam Soru Sayısı",
                "Cevaplanan Soru Sayısı",
                "Doğru Cevap Sayısı",
                "Yanlış Cevap Sayısı",
                "Ödev Puanı",
                "Geliştirmesi Gereken Konular",
                "Motivasyon Düzeyi",
                "Öğretmene Tavsiye",
            ]]);
            $this->googleSheetsService->shareSpreadsheet($spreadsheetId, $email, "writer");
            $this->googleSheetsService->shareSpreadsheet($spreadsheetId, auth()->user()->email, "writer");
            $spreadsheetUrl = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/edit";


            $exam = Exam::create([
                'name' => $request->name,
                'image_name' => $request->image_name,
                'assistant_id' => $assistantId,
                'sinif_duzeyi' => $request->sinif_duzeyi,
                'soru_sayisi' => $request->soru_sayisi,
                'zorluk_seviyesi' => $request->zorluk_seviyesi,
                'konu' => $request->konu,
                'spreadsheet_id' => $spreadsheetId,
                'status' => $request->status ?? 1,
            ]);

            Db::commit();


            return response()->json([
                "message" => "İnteraktif ödev oluşturuldu",
                "spreadsheet_url" => $spreadsheetUrl,
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

    public function finishExamForStudent(Request $request)
    {
        $request->validate([
            "student_name" => "required|string",
            "exam_id" => "required|string",
            "thread_id" => "required|string",
        ]);


        DB::beginTransaction();
        try {
            $api_key = $this->getApiKey();


            $threadMessagesResponse = Http::withHeaders([
                "Authorization" => "Bearer " . $api_key->key,
                "Content-Type" => "application/json",
                "OpenAI-Beta" => "assistants=v2"
            ])
                ->withoutVerifying()
                ->get("https://api.openai.com/v1/threads/{$request->thread_id}/messages");

            $threadMessagesJson = $threadMessagesResponse->json();


            $threadMessagesStatus = $threadMessagesResponse->status();
            if ($threadMessagesStatus != 200 || !isset($threadMessagesJson["data"])) {
                return response()->json([
                    "message" => "Sohbet geçimişi alınamadı!"
                ], 500);
            }
            $threadMessageList = $threadMessagesJson["data"];

            //  Completions API'ye gönderilecek formatta mesaj geçmişi
            $messageHistory = [];
            foreach (array_reverse($threadMessageList) as $message) {
                $messageHistory[] = [
                    "role" => $message["role"],
                    "content" => $message["content"][0]["text"]["value"],
                ];
            }


            $exam = Exam::findOrFail($request->exam_id);
            $totalQuestion = $exam->soru_sayisi;


            $allJsonResponse = $this->sendComplationsPrompt(
                $api_key,
                array_merge(
                    $messageHistory,
                    [
                        [
                            "role" => "system",
                            "content" => "Bu konuşma içerisindeki bilgilere göre aşağıdaki verileri hazırla ve json formatında yaz. Sadece json'u yaz. Json içerisinde kullanacağın key'leri her bir maddenin başında yazıyorum. Ayrıca verileri benim yazdığım sırada json içerisine yerleştir. Benim yazdığım sıralamaya uyarak json içerisindeki verileri yerleştir. Json içerisine verileri yerleştirirken sıralamanın benim söylediğimin aynısı olduğundan emin ol. Hiçbir selamlama ve açıklama metni ekleme. Formatlama ve biçimlendirme amacıyla bile json dışında hiçbir karakter kullanma. \n\n1) (tamamlanma_zamani)Tamamlanma Zamanı (ilk-son mesaj arasında geçen süre. Örnek format: \"5 dakika\") \n2) (toplam_soru)Toplam Soru Sayısı = {$totalQuestion} \n3) (cevaplanan_soru)Cevaplanan Soru Sayısı (Öğrencinin tek başına ve asistan ile beraber cavapladığı soru sayısı) \n4) (dogru_cevap)Doğru Cevap Sayısı (Öğrencinin doğru cevap verdiği soru sayısı) \n5) (yanlis_cevap)Yanlış Cevap Sayısı (Öğrencinin yanlış cevap verdiği soru sayısı) \n6) (odev_puani)Ödev Puanı (Öğrencinin bu ödevden 100 üzerinden aldığı ödev puanı) \n7) (gelistirilmesi_gereken_konular)Geliştirmesi Gereken Konular (Öğrencinin bu ödev çerçevesinde kendini geliştirmesi gereken konular. Düz metin olarak yaz. Eğer her konuda iyi ise bu alanı boş bırak) \n8) (motivasyon_duzeyi)Motivasyon Düzeyi (Öğrencinin ders motivasyonu) \n9) (ogretmene_tavsiye)Öğretmene Tavsiye (Öğrencinin daha iyi eğitim alması için bu dersin öğretmenine tavsiyeler.)"
                        ]
                    ],
                ),
                null,
                true,
            );


            $jsonResponse = json_decode($allJsonResponse, true);


            $spreadsheetId = $exam->spreadsheet_id;

            $this->googleSheetsService->setSpreadsheetId($spreadsheetId);
            // $this->googleSheetsService->appendRow("'{$this->tableName}'!A1", [array_values($jsonResponse)]);
            $this->googleSheetsService->appendRow("A1", [array_values($jsonResponse)]);
    

            return response()->json([
                "message" => "Ödev değerlendirmesi oluşturuldu.",
                "data" => $jsonResponse,
            ]);


            /* $timeMessageList = array_merge($messageHistory, [["role" => "system", "content" => "İlk mesaj ile son mesaj arasındaki süreyi yaz. Sadece süreyi yaz. Hiçbir selamlama ve açıklama metni ekleme. Formatlama ve biçimlendirme amacıyla bile süre dışında hiçbir karakter kullanma. Süreyi \"hh:mm\" formatında yaz."]]);
            $time = $this->sendComplationsPrompt($api_key, $timeMessageList, null); */

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

    private function addRow(Request $request)
    {
        $data = [
            [$request->input('column1'), $request->input('column2')]
        ];

        $spreadsheetId = $request->input('spreadsheet_id');

        $this->googleSheetsService->setSpreadsheetId($spreadsheetId);
        $this->googleSheetsService->appendRow('Sheet1!A1', $data);

        return response()->json(['message' => 'Data added successfully']);
    }
}
