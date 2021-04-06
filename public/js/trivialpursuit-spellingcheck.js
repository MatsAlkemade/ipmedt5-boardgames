function spellingCheck() {
    let answer = document.getElementById('js--answer').value;
    let correct_answer = document.getElementById('js--correct-answer').value;

    if(correct_answer.match(/^-?\d+$/)){
        if(Object.is(answer, correct_answer)){
            console.log("int goed");
        }
        else{
            console.log("int fout");
        }
    }
    else{
        answer = answer.toLowerCase();
        correct_answer = correct_answer.toLowerCase();
        let spellingcheck = stringSimilarity.compareTwoStrings(correct_answer, answer);
        if(spellingcheck >= 0.8){
            console.log('String goed')
        }
        else{
            console.log('String fout')
        }
    }
}