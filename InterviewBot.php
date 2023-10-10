<?php
require_once('config.php');
require_once('OpenAI_API.php');
require_once('SendEmail.php');

// Initialize variables
$questionsAndAnswers = [];
$uuid = generateUuid();
$subject = "Interview Data: $uuid";
$headers = "From: no-reply@example.com\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";

// Get POST data
$fullName = $_POST['fullName'];
$answers = $_POST['answers'];

$questionsAndAnswers["Full Name:"] = $fullName;

// OpenAI API
$openAI = new OpenAI_API();

$personalInfoQuestions = [
  'Hello! I\'m Ms. Eva Gonzalez. May I have your name please?',
  'Awesome, nice to meet you! and how may we reach you? like your contact number?',
  'Great! And your email address?',
  'Thank you! How about your home address?',
  'Interesting! How many years of data entry experience do you have?',
  'Fantastic! Could you list the names of previous companies where you worked in a data entry role?',
  'Wonderful! What types of data did you handle at those companies?',
  'Impressive! What\'s your average typing speed?',
  'Very good! How do you ensure accuracy while entering data?',
  'Nice! Have you been tested for typing speed and accuracy? Share the results if you have.',
  'Now, what\'s the highest level of education you\'ve completed?',
  'Excellent! Where did you go to school?',
  'Intriguing! Any relevant coursework or training?',
  'Cool! List the data entry software you\'re proficient in.',
  'Good stuff! Are you familiar with keyboard shortcuts?',
  'Tell me about your experience formatting data.',
  'How do you validate data?',
  'Ever worked with large datasets? How did you manage?',
  'How do you identify and correct errors?',
  'Talk to me about data security and confidentiality.',
  'How do you handle sensitive information?',
  'How do you maintain focus?',
  'Share an example where your attention to detail mattered.',
  'How do you prioritize tasks?',
  'Share your strategies for staying organized.',
  'How do you communicate effectively?',
  'Ever collaborated on data entry tasks?',
  'Tell me about a challenging issue you\'ve resolved.',
  'How do you troubleshoot data discrepancies?',
  'Explain your approach to quality control.',
  'How do you double-check your work?',
  'Open to varying levels of complexity?',
  'How adaptable are you to changes in requirements?',
];

$questionCounter = 1;

foreach ($personalInfoQuestions as $index => $question) {
    $answer = $answers[$index];
    $questionsAndAnswers[$question] = $answer;

    if ($questionCounter % 4 === 0) {
        $prompt = "Tell a light-hearted, appropriate joke related to interview questions or interviews.";
        $maxTokens = 50;
        $joke = $openAI->callAPI($prompt, $maxTokens);
        echo "Here's a joke for you: $joke\n";
    }

    $questionCounter++;
}

$emailBody = "Interview conducted at: " . date('Y-m-d H:i:s') . "\nUUID: $uuid\n\n";
foreach ($questionsAndAnswers as $question => $answer) {
    $emailBody .= "$question $answer\n";
}

foreach ($emailAddresses as $email) {
    sendEmail($email, $subject, $emailBody, $headers);
}
?>
