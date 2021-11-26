<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getDatabaseData()['courses'] as $course) {
            Course::create([
                'name' => $course['__2']['value'],
                'course_code' => substr($course['__1']['value'], 4, 3),
                'practical_credit_hours' => $course['__3']['value'][4],
                'theory_credit_hours' => $course['__3']['value'][2],
                'department_code' => substr($course['__1']['value'], 0, 3),
            ]);
        }
    }

    public function getDatabaseData()
    {
        $json = '{"Scheme of Studies BS Software Engineering": [
            {
                "__1": {
                    "value": "CSI-301",
                    "position": [
                        350,
                        288,
                        436,
                        316
                    ],
                    "confidence": 1.0,
                    "review_required": false
                },
                "__2": {
                    "value": "Programming Fundamentals",
                    "position": [
                        507,
                        288,
                        828,
                        316
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "4(3-1)",
                    "position": [
                        1134,
                        288,
                        1201,
                        316
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-303",
                    "position": [
                        350,
                        324,
                        436,
                        352
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Introduction to Computing",
                    "position": [
                        507,
                        324,
                        810,
                        352
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "4(3-1)",
                    "position": [
                        1134,
                        324,
                        1201,
                        352
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "ENG-321",
                    "position": [
                        350,
                        359,
                        450,
                        387
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Functional English",
                    "position": [
                        507,
                        359,
                        712,
                        387
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        359,
                        1201,
                        387
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "ISL-321",
                    "position": [
                        350,
                        395,
                        433,
                        423
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Islamic Studies / Ethics",
                    "position": [
                        507,
                        395,
                        764,
                        423
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "2(2-0)",
                    "position": [
                        1134,
                        395,
                        1201,
                        423
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "MTH-323 Semester 2",
                    "position": [
                        350,
                        430,
                        479,
                        529
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Calculus and Analytical Geometry",
                    "position": [
                        507,
                        430,
                        886,
                        458
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0) 16",
                    "position": [
                        1134,
                        430,
                        1359,
                        494
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-302",
                    "position": [
                        350,
                        537,
                        436,
                        564
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Object Oriented Programming",
                    "position": [
                        507,
                        537,
                        849,
                        564
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "4(3-1)",
                    "position": [
                        1134,
                        537,
                        1201,
                        564
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-304",
                    "position": [
                        350,
                        572,
                        436,
                        600
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Discrete Structures",
                    "position": [
                        507,
                        572,
                        723,
                        600
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        572,
                        1201,
                        600
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "ENG-322",
                    "position": [
                        350,
                        608,
                        450,
                        635
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "English Comprehension & Composition",
                    "position": [
                        507,
                        608,
                        948,
                        635
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        608,
                        1201,
                        635
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "MTH-324",
                    "position": [
                        350,
                        643,
                        456,
                        671
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Advanced Calculus",
                    "position": [
                        507,
                        643,
                        718,
                        671
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        643,
                        1201,
                        671
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "ELT-321",
                    "position": [
                        350,
                        679,
                        440,
                        707
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Basic Electronics",
                    "position": [
                        507,
                        679,
                        694,
                        707
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        679,
                        1201,
                        707
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "PST-321 Semester 3",
                    "position": [
                        350,
                        714,
                        479,
                        813
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Pakistan Studies",
                    "position": [
                        507,
                        714,
                        691,
                        742
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "2(2-0) 18",
                    "position": [
                        1134,
                        714,
                        1359,
                        778
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-401",
                    "position": [
                        350,
                        821,
                        436,
                        849
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Data Structure and Algorithms",
                    "position": [
                        507,
                        821,
                        851,
                        849
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(2-1)",
                    "position": [
                        1134,
                        821,
                        1201,
                        849
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-403",
                    "position": [
                        350,
                        856,
                        436,
                        884
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Digital Logic and Design",
                    "position": [
                        507,
                        856,
                        774,
                        884
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(2-1)",
                    "position": [
                        1134,
                        856,
                        1201,
                        884
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SWE-401",
                    "position": [
                        350,
                        891,
                        452,
                        919
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Introduction to Software Engineering",
                    "position": [
                        507,
                        891,
                        928,
                        919
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        891,
                        1201,
                        919
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "ENG-421",
                    "position": [
                        350,
                        927,
                        450,
                        955
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Communication Skills",
                    "position": [
                        507,
                        927,
                        749,
                        955
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        927,
                        1201,
                        955
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "STA-321",
                    "position": [
                        350,
                        963,
                        443,
                        990
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Introduction to Statistical Theory",
                    "position": [
                        507,
                        963,
                        880,
                        990
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        963,
                        1201,
                        990
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "MTH-424 Semester 4",
                    "position": [
                        350,
                        998,
                        479,
                        1097
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Linear Algebra",
                    "position": [
                        507,
                        998,
                        670,
                        1026
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0) 18",
                    "position": [
                        1134,
                        998,
                        1359,
                        1061
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-402",
                    "position": [
                        350,
                        1105,
                        436,
                        1132
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Operating Systems",
                    "position": [
                        507,
                        1105,
                        719,
                        1132
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(2-1)",
                    "position": [
                        1134,
                        1105,
                        1201,
                        1132
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SWE-450",
                    "position": [
                        350,
                        1140,
                        452,
                        1168
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Object Oriented Software Design",
                    "position": [
                        507,
                        1140,
                        880,
                        1168
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(2-1)",
                    "position": [
                        1134,
                        1140,
                        1201,
                        1168
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-405",
                    "position": [
                        350,
                        1176,
                        436,
                        1203
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Introduction to Database Systems",
                    "position": [
                        507,
                        1176,
                        890,
                        1203
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "4(3-1)",
                    "position": [
                        1134,
                        1176,
                        1201,
                        1203
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-506",
                    "position": [
                        350,
                        1211,
                        436,
                        1239
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Analysis of Algorithms",
                    "position": [
                        507,
                        1211,
                        758,
                        1239
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        1211,
                        1201,
                        1239
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-406 Semester 5",
                    "position": [
                        350,
                        1246,
                        479,
                        1345
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Computer Communications and Networks",
                    "position": [
                        507,
                        1246,
                        983,
                        1274
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0) 16",
                    "position": [
                        1134,
                        1246,
                        1359,
                        1310
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-501",
                    "position": [
                        350,
                        1353,
                        436,
                        1381
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Web Engineering",
                    "position": [
                        507,
                        1353,
                        700,
                        1381
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(2-1)",
                    "position": [
                        1134,
                        1353,
                        1201,
                        1381
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SWE-501",
                    "position": [
                        350,
                        1388,
                        452,
                        1416
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Software Requirements Engineering",
                    "position": [
                        507,
                        1388,
                        915,
                        1416
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(2-1)",
                    "position": [
                        1134,
                        1388,
                        1201,
                        1416
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SWE-550",
                    "position": [
                        350,
                        1424,
                        452,
                        1452
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Software Quality Assurance",
                    "position": [
                        507,
                        1424,
                        819,
                        1452
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        1424,
                        1201,
                        1452
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SWE-503",
                    "position": [
                        350,
                        1459,
                        452,
                        1487
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Software Engineering Economics",
                    "position": [
                        507,
                        1459,
                        877,
                        1487
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        1459,
                        1201,
                        1487
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "BBA-506",
                    "position": [
                        350,
                        1495,
                        447,
                        1523
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Human Resource Management",
                    "position": [
                        507,
                        1495,
                        859,
                        1523
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        1495,
                        1201,
                        1523
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-601 Semester 6",
                    "position": [
                        350,
                        1530,
                        479,
                        1629
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Human Computer Interaction",
                    "position": [
                        507,
                        1530,
                        841,
                        1558
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0) 18",
                    "position": [
                        1134,
                        1530,
                        1359,
                        1593
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SOC-307",
                    "position": [
                        350,
                        1637,
                        447,
                        1664
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Introduction to Sociology",
                    "position": [
                        507,
                        1637,
                        793,
                        1664
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        1637,
                        1201,
                        1664
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SWE-505",
                    "position": [
                        350,
                        1672,
                        452,
                        1700
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Professional Practices",
                    "position": [
                        507,
                        1672,
                        753,
                        1700
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        1672,
                        1201,
                        1700
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "CSI-607",
                    "position": [
                        350,
                        1708,
                        436,
                        1735
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Artificial Intelligence",
                    "position": [
                        507,
                        1708,
                        739,
                        1735
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(2-1)",
                    "position": [
                        1134,
                        1708,
                        1201,
                        1735
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SWE-551",
                    "position": [
                        350,
                        1743,
                        452,
                        1771
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Software Design and Architecture",
                    "position": [
                        507,
                        1743,
                        888,
                        1771
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(2-1)",
                    "position": [
                        1134,
                        1743,
                        1201,
                        1771
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SWE-553",
                    "position": [
                        350,
                        1779,
                        452,
                        1807
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Visual Programming",
                    "position": [
                        507,
                        1779,
                        734,
                        1807
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(2-1)",
                    "position": [
                        1134,
                        1779,
                        1201,
                        1807
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "Semester 7",
                    "position": [
                        350,
                        1885,
                        479,
                        1913
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Elective-I",
                    "position": [
                        507,
                        1814,
                        610,
                        1842
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3 18",
                    "position": [
                        1134,
                        1814,
                        1359,
                        1877
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SWE-603",
                    "position": [
                        350,
                        1920,
                        452,
                        1948
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Software Project Management",
                    "position": [
                        507,
                        1920,
                        855,
                        1948
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(3-0)",
                    "position": [
                        1134,
                        1920,
                        1201,
                        1948
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SWE-605",
                    "position": [
                        350,
                        1956,
                        452,
                        1984
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Software Metrics",
                    "position": [
                        507,
                        1956,
                        701,
                        1984
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "3(2-1)",
                    "position": [
                        1134,
                        1956,
                        1201,
                        1984
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            },
            {
                "__1": {
                    "value": "SWE-607",
                    "position": [
                        350,
                        1991,
                        452,
                        2019
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__2": {
                    "value": "Mathematical tools for Software Engineering",
                    "position": [
                        507,
                        1991,
                        1015,
                        2019
                    ],
                    "confidence": 0,
                    "review_required": true
                },
                "__3": {
                    "value": "Page 3(2-1)",
                    "position": [
                        1134,
                        1991,
                        1431,
                        2072
                    ],
                    "confidence": 0,
                    "review_required": true
                }
            }
        ]}';

        $data = json_decode($json, true);

        return $data;
    }
}
