<?php
class Plural
{
    static public function toPlural($word)
    {
        $irregular = array(
            "ability" => "abilities",
            "aircraft" => "aircraft",
            "analysis" => "analyses",
            "appendix" => "appendices",
            "avenue" => "avenues",
            "baby" => "babies",
            "bacterium" => "bacteria",
            "belief" => "beliefs",
            "buffalo" => "buffaloes",
            "cactus" => "cacti",
            "cargo" => "cargoes",
            "carry" => "carries",
            "criterion" => "criteria",
            "craft" => "craft",
            "cuckoo" => "cuckoos",
            "datum" => "data",
            "deer" => "deer",
            "diagnosis" => "diagnoses",
            "echo" => "echoes",
            "ellipsis" => "ellipses",
            "embargo" => "embargoes",
            "emphasis" => "emphases",
            "family" => "families",
            "fish" => "fish",
            "focus" => "foci",
            "foot" => "feet",
            "fungus" => "fungi",
            "grief" => "grief",
            "human" => "humans",
            "hippopotamus" => "hippopotamuses",
            "index" => "indices",
            "journey" => "journeys",
            "kangaroo" => "kangaroos",
            "knife" => "knives",
            "leaf" => "leaves",
            "life" => "lives",
            "loaf" => "loaves",
            "man" => "men",
            "matrix" => "matrices",
            "medium" => "media",
            "money" => "monies",
            "monkey" => "monkeys",
            "mosquito" => "mosquitoes",
            "mouse" => "mice",
            "octopus" => "octopuses",
            "ox" => "oxen",
            "parenthesis" => "parentheses",
            "piano" => "pianos",
            "person" => "people",
            "photo" => "photos",
            "potato" => "potatoes",
            "quiz" => "quizzes",
            "ray" => "rays",
            "reef" => "reefs",
            "relief" => "reliefs",
            "roof" => "roofs",
            "self" => "selves",
            "snafu" => "snafus",
            "society" => "societies",
            "stadium" => "stadia",
            "story" => "stories",
            "studio" => "studios",
            "syllabus" => "syllabi",
            "thesis" => "theses",
            "tornado" => "tornadoes",
            "tuna" => "tuna",
            "vertebra" => "vertebrae",
            "virtuoso" => "virtuosos",
            "virus" => "viruses",
            "volcano" => "volcanoes",
            "zero" => "zeros"
        );


        if (array_key_exists(strtolower($word), $irregular)) {
            return $irregular[strtolower($word)];
        }

        $lastChar = strtolower(substr($word, -1));
        $lastTwoChars = strtolower(substr($word, -2));

        if ($lastTwoChars == "ch" || $lastTwoChars == "sh" || $lastChar == "s" || $lastChar == "x" || $lastChar == "z") {
            return $word . "es";
        } elseif ($lastTwoChars == "ay" || $lastTwoChars == "ey" || $lastTwoChars == "iy" || $lastTwoChars == "oy" || $lastTwoChars == "uy") {
            return $word . "s";
        } else {
            return $word . "s";
        }
    }

    static public function toSingular($word)
    {
        $irregulares = array(
            "abilities" => "ability",
            "aircraft" => "aircraft",
            "analyses" => "analysis",
            "appendices" => "appendix",
            "avenues" => "avenue",
            "babies" => "baby",
            "bacteria" => "bacterium",
            "beliefs" => "belief",
            "buffaloes" => "buffalo",
            "cacti" => "cactus",
            "cargoes" => "cargo",
            "carries" => "carry",
            "criteria" => "criterion",
            "craft" => "craft",
            "cuckoos" => "cuckoo",
            "data" => "datum",
            "deer" => "deer",
            "diagnoses" => "diagnosis",
            "echoes" => "echo",
            "ellipses" => "ellipsis",
            "embargoes" => "embargo",
            "emphases" => "emphasis",
            "families" => "family",
            "fish" => "fish",
            "foci" => "focus",
            "feet" => "foot",
            "fungi" => "fungus",
            "grief" => "grief",
            "humans" => "human",
            "hippopotamuses" => "hippopotamus",
            "indices" => "index",
            "journeys" => "journey",
            "kangaroos" => "kangaroo",
            "knives" => "knife",
            "leaves" => "leaf",
            "lives" => "life",
            "loaves" => "loaf",
            "men" => "man",
            "matrices" => "matrix",
            "media" => "medium",
            "monies" => "money",
            "monkeys" => "monkey",
            "mosquitoes" => "mosquito",
            "mice" => "mouse",
            "octopuses" => "octopus",
            "oxen" => "ox",
            "parentheses" => "parenthesis",
            "pianos" => "piano",
            "people" => "person",
            "photos" => "photo",
            "potatoes" => "potato",
            "quizzes" => "quiz",
            "rays" => "ray",
            "reefs" => "reef",
            "reliefs" => "relief",
            "roofs" => "roof",
            "selves" => "self",
            "snafus" => "snafu",
            "societies" => "society",
            "stadia" => "stadium",
            "stories" => "story",
            "studios" => "studio",
            "syllabi" => "syllabus",
            "theses" => "thesis",
            "tornadoes" => "tornado",
            "tuna" => "tuna",
            "vertebrae" => "vertebra",
            "virtuosos" => "virtuoso",
            "viruses" => "virus",
            "volcanoes" => "volcano",
            "zeros" => "zero"
        );
        $lowerWord = strtolower($word);
        if (array_key_exists($lowerWord, $irregulares)) {
            return $irregulares[$lowerWord];
        } else {
            // Check if the word ends in "s" and remove it
            $lastChar = substr($lowerWord, -1);
            $lastThreeChar = substr($lowerWord, -3);
            $lastFourChar = substr($lowerWord, -4);
            if ($lastFourChar == "ches" || $lastFourChar == "shes"){
                return substr($lowerWord, 0, -2);
             }
            if ($lastThreeChar == "ses" || $lastThreeChar == "xes" || $lastThreeChar == "zes"){
                return substr($lowerWord, 0, -2);
             }



            if ($lastChar == "s"){
                return substr($lowerWord, 0, -1);
            }
            return $word;
        }
    }
}
