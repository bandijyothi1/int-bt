let currentQuestionIndex = 0;
let userData = {};
const chatBox = document.getElementById('chat-box');
const userInput = document.getElementById('user-input');
const sendButton = document.getElementById('send-button');

const questions = [
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

async function apiRequest(endpoint, payload) {
  const response = await fetch(endpoint, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(payload),
  });

  return await response.json();
}

async function getBotResponse(input) {
  const data = await apiRequest('InterviewBot.php', { prompt: input });
  return data.response;
}

function appendMessage(message, className) {
  const messageDiv = document.createElement('div');
  messageDiv.className = `message ${className}`;
  messageDiv.innerText = message;
  chatBox.appendChild(messageDiv);
  chatBox.scrollTop = chatBox.scrollHeight;
}

function recordAnswer(answer, index) {
  fetch('RecordAnswer.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ answer, questionIndex: index }),
  });
}

async function initChat() {
  appendMessage("Hello! I'm Ms. Eva Gonzalez.", 'bot-message');
  appendMessage(questions[0], 'bot-message');
}

async function sendInput() {
  const userResponse = userInput.value.trim();
  if (!userResponse) return;

  userData[currentQuestionIndex] = userResponse;
  appendMessage(userResponse, 'user-message');
  userInput.value = '';

  recordAnswer(userResponse, currentQuestionIndex);

  if (currentQuestionIndex < questions.length - 1) {
    currentQuestionIndex++;
    const nextQuestion = await getBotResponse(questions[currentQuestionIndex]);
    appendMessage(nextQuestion, 'bot-message');
  } else {
    const closingStatement = await getBotResponse("Thank you for completing the interview.");
    appendMessage(closingStatement, 'bot-message');
  }
}

sendButton.addEventListener('click', sendInput);

userInput.addEventListener('keydown', function(event) {
  if (event.keyCode === 13) {
    sendInput();
  }
});

initChat();
