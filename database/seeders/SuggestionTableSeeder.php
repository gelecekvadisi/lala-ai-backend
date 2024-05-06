<?php

namespace Database\Seeders;

use App\Models\Suggestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuggestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suggestions = array(
            array('category_id' => 1,'status' => 1,'suggestions' => 'Write me an email to the finance department to ask for a budget increase.','created_at' => now(),'updated_at' => now()),
            array('category_id' => 1,'status' => 1,'suggestions' => 'What is the importance of a clear and concise subject line in an email?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 1,'status' => 1,'suggestions' => 'How can you effectively introduce yourself in the opening of an email?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 1,'status' => 1,'suggestions' => 'What strategies can you use to maintain a professional and polite tone in your emails?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 1,'status' => 1,'suggestions' => 'Why is it important to provide relevant details and context in your email\'s main content?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 1,'status' => 1,'suggestions' => 'How do you strike a balance between being concise and providing all necessary information in an email?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 1,'status' => 1,'suggestions' => 'How can you tailor your email\'s tone and content based on your relationship with the recipient?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 1,'status' => 1,'suggestions' => 'How can you effectively use attachments and hyperlinks in your emails to enhance communication?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 1,'status' => 1,'suggestions' => 'What are some common mistakes to avoid when writing professional emails?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 1,'status' => 1,'suggestions' => 'What are the key components of a proper email closing, and why are they important?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 12,'status' => 1,'suggestions' => 'What are the benefits of incorporating technology in the classroom?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 12,'status' => 1,'suggestions' => 'How does project-based learning contribute to student engagement and understanding?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 12,'status' => 1,'suggestions' => 'What are the key differences between traditional education and online learning?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 12,'status' => 1,'suggestions' => 'How can educators promote critical thinking skills among students?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 12,'status' => 1,'suggestions' => 'What is the role of standardized testing in assessing student knowledge?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 12,'status' => 1,'suggestions' => 'What are the advantages and challenges of personalized learning approaches?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 12,'status' => 1,'suggestions' => 'How does cultural diversity in schools impact the learning environment?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 12,'status' => 1,'suggestions' => 'What strategies can teachers use to effectively manage classroom behavior?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 12,'status' => 1,'suggestions' => 'What role does extracurricular involvement play in a student\'s overall education experience?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 12,'status' => 1,'suggestions' => 'How can education systems better prepare students for the demands of the modern workforce?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 11,'status' => 1,'suggestions' => 'What are the key steps in the writing process, from brainstorming to finalizing a piece?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 11,'status' => 1,'suggestions' => 'How can you improve the clarity and coherence of your writing during the editing phase?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 11,'status' => 1,'suggestions' => 'What techniques can you use to spot and correct grammar and punctuation errors in your writing?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 11,'status' => 1,'suggestions' => 'Why is it important to consider your target audience when writing, and how does it impact your approach?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 11,'status' => 1,'suggestions' => 'What strategies can you employ to avoid repetition and enhance the overall flow of your writing?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 11,'status' => 1,'suggestions' => 'How do you effectively integrate quotes or references into your writing while maintaining your own voice?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 11,'status' => 1,'suggestions' => 'What role does peer or external feedback play in the writing and editing process? How can you use it effectively?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 11,'status' => 1,'suggestions' => 'What are the differences between substantive editing and proofreading, and when should you use each?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 11,'status' => 1,'suggestions' => 'How can you create a strong thesis statement or central argument that guides your writing effectively?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 11,'status' => 1,'suggestions' => 'What are some tools or software that can assist with grammar checking and proofreading during the editing process?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 11,'status' => 1,'suggestions' => 'What are some tools or software that can assist with grammar checking and proofreading during the editing process?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 12,'status' => 1,'suggestions' => 'How does inclusive education benefit both students with special needs and the general student population?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 10,'status' => 1,'suggestions' => 'What are the key factors to consider when determining your investment goals and risk tolerance?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 10,'status' => 1,'suggestions' => 'What are the main differences between stocks, bonds, and mutual funds as investment options?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 10,'status' => 1,'suggestions' => 'How does diversification contribute to a well-balanced investment portfolio?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 10,'status' => 1,'suggestions' => 'What is the role of a financial advisor in helping individuals make informed investment decisions?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 10,'status' => 1,'suggestions' => 'What are the potential advantages and risks of investing in real estate?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 10,'status' => 1,'suggestions' => 'How does inflation impact investments and what strategies can be used to mitigate its effects?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 10,'status' => 1,'suggestions' => 'What is the significance of the stock market indices and how are they used to track market performance?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 10,'status' => 1,'suggestions' => 'What are some tax-efficient investment strategies to consider for optimizing returns?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 10,'status' => 1,'suggestions' => 'What are the different types of retirement accounts available, and how do they contribute to long-term financial planning?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 10,'status' => 1,'suggestions' => 'How can an individual determine whether active or passive investment strategies are more suitable for their goals?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 9,'status' => 1,'suggestions' => 'What is the scientific method, and how is it used to investigate and understand the natural world?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 9,'status' => 1,'suggestions' => 'Can you explain the basic principles of evolution and natural selection?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 9,'status' => 1,'suggestions' => 'What is the role of DNA in genetics and heredity?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 9,'status' => 1,'suggestions' => 'How does the greenhouse effect contribute to climate change?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 9,'status' => 1,'suggestions' => 'What are the fundamental particles that make up atoms, and how do they interact to form matter?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 9,'status' => 1,'suggestions' => 'Can you describe the process of photosynthesis and its significance in the production of energy for plants?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 9,'status' => 1,'suggestions' => 'What are some current advancements and applications of biotechnology in medicine and agriculture?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 9,'status' => 1,'suggestions' => 'Explain the different states of matter and how they transition between each other.','created_at' => now(),'updated_at' => now()),
            array('category_id' => 9,'status' => 1,'suggestions' => 'What is the concept of relativity, and how has it impacted our understanding of space and time?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 9,'status' => 1,'suggestions' => 'Describe the layers of the Earth\'s atmosphere and their respective characteristics.','created_at' => now(),'updated_at' => now()),
            array('category_id' => 8,'status' => 1,'suggestions' => 'Who are some of the most influential comedians in history, and what makes their humor timeless?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 8,'status' => 1,'suggestions' => 'What role does observational humor play in stand-up comedy, and how do comedians excel at it?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 8,'status' => 1,'suggestions' => 'How do comedians often use satire and parody to comment on social and political issues?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 8,'status' => 1,'suggestions' => 'What are the different styles of comedy, such as slapstick, dark humor, and surreal humor, and how do comedians utilize them effectively?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 8,'status' => 1,'suggestions' => 'What is the importance of timing and delivery in comedic performances, and how do comedians master these skills?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 8,'status' => 1,'suggestions' => 'What challenges do comedians face when dealing with sensitive or controversial topics, and how do they navigate them?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 8,'status' => 1,'suggestions' => 'How do comedians use self-deprecating humor to connect with their audience and create relatable content?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 8,'status' => 1,'suggestions' => 'What are some common techniques comedians use to engage with and interact with their audience during live performances?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 8,'status' => 1,'suggestions' => 'How has the rise of social media platforms impacted the way comedians share their content and build their careers?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 8,'status' => 1,'suggestions' => 'What are some examples of comedians who successfully transitioned from stand-up comedy to acting or other entertainment ventures?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 7,'status' => 1,'suggestions' => 'Pros: What are the advantages of remote work for employees?
          Cons: What are the challenges that employees might face while working remotely?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 7,'status' => 1,'suggestions' => 'Pros: What are the benefits of renewable energy sources for the environment?
          Cons: What are the potential drawbacks or limitations of using renewable energy?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 7,'status' => 1,'suggestions' => 'Pros: What are the positive impacts of social media on communication and networking?
          Cons: What are the negative effects or concerns associated with excessive social media usage?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 7,'status' => 1,'suggestions' => 'Pros: What are the advantages of globalization for international trade and cultural exchange?
          Cons: What are some of the criticisms or downsides of globalization?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 7,'status' => 1,'suggestions' => 'Pros: What are the benefits of using artificial intelligence in healthcare?
          Cons: What are the ethical and privacy concerns surrounding AI in healthcare?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 7,'status' => 1,'suggestions' => 'Pros: What are the advantages of online education and e-learning?
          Cons: What are the potential limitations or challenges of online learning platforms?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 7,'status' => 1,'suggestions' => 'Pros: What are the positive aspects of a diverse and inclusive workplace?
          Cons: What are the possible difficulties in managing diversity in a work environment?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 7,'status' => 1,'suggestions' => 'Pros: What are the benefits of autonomous vehicles for transportation systems?
          Cons: What are the safety and regulatory concerns related to self-driving cars?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 7,'status' => 1,'suggestions' => 'Pros: What are the advantages of genetically modified crops for agriculture?
          Cons: What are the ecological and ethical considerations associated with GMOs?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 7,'status' => 1,'suggestions' => 'Pros: What are the benefits of a cashless society in terms of convenience and efficiency?
          Cons: What are the potential risks and issues related to a society that relies heavily on digital transactions?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 6,'status' => 1,'suggestions' => 'What is the primary goal of advertising, and how does it impact consumer behavior?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 6,'status' => 1,'suggestions' => 'What are the key elements of a successful advertising campaign?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 6,'status' => 1,'suggestions' => 'How does target audience analysis influence the creation of effective advertising strategies?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 6,'status' => 1,'suggestions' => 'What are the differences between traditional advertising and digital advertising?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 6,'status' => 1,'suggestions' => 'How do advertisers measure the effectiveness of their campaigns and return on investment (ROI)?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 6,'status' => 1,'suggestions' => 'What ethical considerations should advertisers take into account when creating and promoting their campaigns?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 6,'status' => 1,'suggestions' => 'How has the rise of social media changed the landscape of advertising and customer engagement?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 6,'status' => 1,'suggestions' => 'What role does storytelling play in creating compelling and memorable advertising content?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 6,'status' => 1,'suggestions' => 'What are some common trends in modern advertising, such as influencer marketing and native advertising?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 6,'status' => 1,'suggestions' => 'How can advertisers use data and analytics to refine their strategies and reach their target audience more effectively?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 5,'status' => 1,'suggestions' => 'What are the key factors to consider when planning a balanced and nutritious meal?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 5,'status' => 1,'suggestions' => 'How does the process of food digestion work, from the moment you eat to the absorption of nutrients?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 5,'status' => 1,'suggestions' => 'What are some common food allergies and intolerance, and how can people manage them in their diets?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 5,'status' => 1,'suggestions' => 'What are the differences between organic, conventional, and genetically modified foods?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 5,'status' => 1,'suggestions' => 'Can you explain the concept of "superfoods" and provide examples of foods that fall into this category?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 6,'status' => 1,'suggestions' => 'What cultural differences are reflected in traditional cuisines from around the world?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 5,'status' => 1,'suggestions' => 'How does cooking method affect the nutritional value and taste of various foods?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 5,'status' => 1,'suggestions' => 'What are some sustainable practices individuals can adopt to reduce food waste at home?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 5,'status' => 1,'suggestions' => 'Can you outline the benefits of consuming a plant-based diet and share tips for transitioning to one?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 5,'status' => 1,'suggestions' => 'What role do dietary guidelines play in promoting health and preventing chronic diseases?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 4,'status' => 1,'suggestions' => 'What are the key challenges that translators often encounter during the translation process?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 4,'status' => 1,'suggestions' => 'How do cultural nuances and idiomatic expressions impact the accuracy of a translation?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 4,'status' => 1,'suggestions' => 'What strategies can translators use to ensure accurate and contextually appropriate translations?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 4,'status' => 1,'suggestions' => 'How important is it to maintain the tone and style of the original text when translating?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 4,'status' => 1,'suggestions' => 'What considerations should be taken into account when translating technical or specialized content?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 4,'status' => 1,'suggestions' => 'How can machine translation tools be effectively integrated into the translation workflow?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 4,'status' => 1,'suggestions' => 'What role does a translator\'s cultural background play in producing high-quality translations?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 4,'status' => 1,'suggestions' => 'When is localization necessary in translation, and how does it differ from standard translation?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 4,'status' => 1,'suggestions' => 'What ethical considerations should translators be mindful of, especially when dealing with sensitive content?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 4,'status' => 1,'suggestions' => 'How do you strike a balance between staying faithful to the source text and ensuring readability in the target language?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 2,'status' => 1,'suggestions' => 'What are the key elements of a well-structured article?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 2,'status' => 1,'suggestions' => 'How can you choose a compelling and relevant topic for your article?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 2,'status' => 1,'suggestions' => 'What strategies can you use to conduct thorough research for your article?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 2,'status' => 1,'suggestions' => 'How do you create an engaging introduction that captures the reader\'s attention?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 2,'status' => 1,'suggestions' => 'What are some effective techniques for organizing and outlining your article\'s main points?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 2,'status' => 1,'suggestions' => 'How can you incorporate data, statistics, and examples to support your arguments in an article?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 2,'status' => 1,'suggestions' => 'What role does storytelling play in making an article more relatable and impactful?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 2,'status' => 1,'suggestions' => 'How do you strike a balance between formal and conversational tones in article writing?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 2,'status' => 1,'suggestions' => 'What are some methods for ensuring smooth transitions between different sections of an article?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 2,'status' => 1,'suggestions' => 'What steps can you take to revise and polish your article before finalizing it for publication?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 3,'status' => 1,'suggestions' => 'What is the role of artificial intelligence in modern technology, and how is it being applied across various industries?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 3,'status' => 1,'suggestions' => 'How does blockchain technology work, and what are its potential applications beyond cryptocurrencies?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 3,'status' => 1,'suggestions' => 'What are the key benefits and challenges of transitioning to a fully remote or hybrid work environment with the help of technology?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 3,'status' => 1,'suggestions' => 'What is the Internet of Things (IoT), and how is it transforming the way we interact with everyday objects and devices?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 3,'status' => 1,'suggestions' => 'What are the ethical considerations surrounding the use of bio metric technologies, such as facial recognition and fingerprint scanning?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 3,'status' => 1,'suggestions' => 'How does cloud computing impact businesses and individuals, and what are the different types of cloud services available?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 3,'status' => 1,'suggestions' => 'What is cybersecurity, and what measures can individuals and organizations take to protect their digital assets and data?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 3,'status' => 1,'suggestions' => 'How are advancements in virtual reality (VR) and augmented reality (AR) shaping industries like gaming, education, and healthcare?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 3,'status' => 1,'suggestions' => 'What is 5G technology, and how does it differ from previous generations of wireless networks? What potential applications does it enable?','created_at' => now(),'updated_at' => now()),
            array('category_id' => 3,'status' => 1,'suggestions' => 'What is quantum computing, and how might it revolutionize fields such as cryptography, optimization, and scientific research?','created_at' => now(),'updated_at' => now())
          );

        Suggestion::insert($suggestions);
    }
}
