<script>
import {useToast} from "vue-toastification";
import Multiselect from "vue-multiselect";
import axios from "axios";

export default {
    name: "ComponentHealthRecommendationModule",
    components: {Multiselect},
    props: {
        app_env: {
            type: String,
        },
    },
    data: function () {
        return {
            show_console: false,
            template: '',
            user: {
                fio: '',
                birthdate: '',
                gender: '',
                position: '',
                points: null,
                score: 0,
                pressure: '',
                smoking: '',
                selected_diagnoses: [],
                cholesterol: '',
                is_contraindications: true,
                contraindications: [],
            },
            recommendations: {
                disp_group: '',
                disp_recomendation: '',
                prof_group: '',
                prof_recomendation: '',
            },
            order_points: [],
            diagnoses: [],
            diagnoses_count: [],
        };
    },
    setup() {
        const toast = useToast();
        return {toast}
    },
    mounted() {
        if (this.app_env !== 'prod') {
            this.show_console = true;
        }
        if (this.show_console) {
            console.log('ComponentHealthRecommendationModule');
        }
        this.get_order_points();
        this.get_diagnoses();
    },
    methods: {
        showToast() {
            this.toast.info("I'm an info toast!");
            this.toast.success("My toast success", {timeout: 2000});
            this.toast.error("My toast error");
        },
        async get_recommendations() {
            this.toast.info('Делаем запрос на получение рекомендаций из модуля СППВР');
            let score = this.count_score();

            if (score) {
                const requestData = {
                    user: this.user,
                }

                try {
                    const response = await axios.post('/health-recommendation-module/get-recommendations', requestData);

                    if (response) {
                        console.log(response);
                        if ('ma_response' in response.data) {
                            this.recommendations.disp_group = response.data['ma_response']['Результат'][0]['disp_group'];
                            this.recommendations.disp_recomendation = response.data['ma_response']['Результат'][0]['disp_recomendation'];
                            this.recommendations.prof_group = response.data['ma_response']['Результат'][0]['prof_group'];
                            this.recommendations.prof_recomendation = response.data['ma_response']['Результат'][0]['prof_recomendation'];
                        }
                        if ('result' in response.data) {
                            if (response.data['result']) {
                                this.template = 'result';
                            }
                        }
                    }
                } catch (error) {
                    if (error.response) {
                        // The server responded with a status code outside the 2xx range
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    } else if (error.request) {
                        // The request was made but no response was received
                        console.log(error.request);
                    } else {
                        // An error occurred in setting up the request
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
                }

            }
        },
        async get_order_points() {
            const response = await axios.get('/health-recommendation-module/get-order-points');

            if (response) {
                if ('order_points' in response.data) {
                    this.order_points = response.data.order_points;
                }
            }
        },
        async get_diagnoses() {
            const response = await axios.get('/health-recommendation-module/get-diagnoses-list');

            if (response) {
                if ('diagnoses' in response.data) {
                    this.diagnoses = response.data.diagnoses;
                }
            }
        },
        add_diagnose() {
            this.diagnoses_count.push('add 1 more multiselect');
        },
        back_to_start() {
            this.toast.info('На стартовую страницу');
            this.template = '';
        },
        addTag(newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            console.log('tag', tag);
            this.options.push(tag)
            this.user.points.push(tag)
        },
        count_score() {
            let userGender = this.check_gender();
            let userAge = this.check_date();
            let userPressure = this.check_pressure();
            let userSmoking = this.check_smoking();
            let userCholesterol = this.check_cholesterol();
            if (userGender && userSmoking && userAge && userCholesterol && userPressure) {
                this.getUserScore(userGender, userSmoking, userAge, userCholesterol, userPressure);
                return true;
            }
            return false;
        },
        check_gender() {
            let result = false;
            let genderEl = document.getElementById('block-gender');
            if (genderEl) {
                if (this.user.gender === '') {
                    if (!genderEl.classList.contains('error')) {
                        genderEl.classList.add('error');
                    }
                } else {
                    if (genderEl.classList.contains('error')) {
                        genderEl.classList.remove('error');
                    }
                    result = this.user.gender;
                }
            }
            return result;
        },
        check_smoking() {
            let result = false;
            let smokingEl = document.getElementById('block-smoking');
            if (smokingEl) {
                if (this.user.smoking === '') {
                    if (!smokingEl.classList.contains('error')) {
                        smokingEl.classList.add('error');
                    }
                } else {
                    if (smokingEl.classList.contains('error')) {
                        smokingEl.classList.remove('error');
                    }
                    result = this.user.smoking;
                }
            }
            return result;
        },
        check_date() {
            let result = false;
            let dateEl = document.getElementById('block-date');
            if (dateEl) {
                if (this.user.birthdate === '') {
                    if (!dateEl.classList.contains('error')) {
                        dateEl.classList.add('error');
                    }
                } else {
                    if (dateEl.classList.contains('error')) {
                        dateEl.classList.remove('error');
                    }
                    let userAge = this.getUserAge();
                    if (userAge < 40) {
                        result = userAge;
                    }
                    if (userAge >= 40 && userAge < 45) {
                        result = 40;
                    }
                    if (userAge >= 45 && userAge < 50) {
                        result = 45;
                    }
                    if (userAge >= 50 && userAge < 55) {
                        result = 50;
                    }
                    if (userAge >= 55 && userAge < 60) {
                        result = 55;
                    }
                    if (userAge >= 60 && userAge < 65) {
                        result = 60;
                    }
                    if (userAge >= 65 && userAge < 70) {
                        result = 65;
                    }
                    if (userAge >= 70 && userAge < 75) {
                        result = 70;
                    }
                    if (userAge >= 75 && userAge < 80) {
                        result = 75;
                    }
                    if (userAge >= 80 && userAge < 85) {
                        result = 80;
                    }
                    if (userAge >= 85) {
                        result = 85;
                    }
                }
            }
            return result;
        },
        check_pressure() {
            let result = false;
            let pressureEl = document.getElementById('block-pressure');
            if (pressureEl) {
                if (this.user.pressure === '') {
                    if (!pressureEl.classList.contains('error')) {
                        pressureEl.classList.add('error');
                    }
                } else {
                    if (pressureEl.classList.contains('error')) {
                        pressureEl.classList.remove('error');
                    }
                    result = this.getUserPressure();
                }
            }
            return result;
        },
        check_cholesterol() {
            let result = false;
            let cholesterolEl = document.getElementById('block-cholesterol');
            if (cholesterolEl) {
                if (this.user.cholesterol === '') {
                    if (!cholesterolEl.classList.contains('error')) {
                        cholesterolEl.classList.add('error');
                    }
                } else {
                    if (cholesterolEl.classList.contains('error')) {
                        cholesterolEl.classList.remove('error');
                    }
                    result = this.getUserCholesterol();
                }
            }
            return result;
        },
        getUserAge() {
            let now = new Date();
            let birthdate = new Date(this.user.birthdate);
            let diff = now.getTime() - birthdate.getTime();
            let userAge = Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
            return userAge;
        },
        getUserCholesterol() {
            /** Диапазоны холестерина 3-3.9 / 4-4.9 / 5-5.9 / 6-6.9 / 7-7.9 / 8 */
            let userCholesterol = 0;
            if (this.user.cholesterol < 4) {
                userCholesterol = 3;
            } else if (this.user.cholesterol >= 4 && this.user.cholesterol < 5) {
                userCholesterol = 4;
            } else if (this.user.cholesterol >= 5 && this.user.cholesterol < 6) {
                userCholesterol = 5;
            } else if (this.user.cholesterol >= 6 && this.user.cholesterol < 7) {
                userCholesterol = 6;
            } else if (this.user.cholesterol >= 7 && this.user.cholesterol < 8) {
                userCholesterol = 7;
            } else if (this.user.cholesterol >= 8) {
                userCholesterol = 8;
            } else {
                userCholesterol = false;
            }
            return userCholesterol;
        },
        getUserPressure() {
            /** Диапазоны давления */
            let userPressure = 0;
            if (this.user.pressure < 120) {
                userPressure = 100;
            } else if (this.user.pressure >= 120 && this.user.pressure < 140) {
                userPressure = 120;
            } else if (this.user.pressure >= 140 && this.user.pressure < 160) {
                userPressure = 140;
            } else if (this.user.pressure >= 160 && this.user.pressure < 180) {
                userPressure = 160;
            } else if (this.user.pressure >= 180) {
                userPressure = 180;
            } else {
                userPressure = 180;
            }
            return userPressure;
        },
        getUserScore(gender, smoking, age, cholesterol, pressure) {
            console.log('gender', gender, 'smoking', smoking, 'age', age, 'cholesterol', cholesterol, 'pressure', pressure);

            let result = false;
            let data = {
                'm': {
                    'y': {
                        40: {
                            3: {
                                100: 3,
                                120: 4,
                                140: 6,
                                160: 8,
                            },
                            4: {
                                100: 4,
                                120: 5,
                                140: 7,
                                160: 9,
                            },
                            5: {
                                100: 5,
                                120: 6,
                                140: 8,
                                160: 11,
                            },
                            6: {
                                100: 6,
                                120: 8,
                                140: 10,
                                160: 13,
                            },
                        },
                        45: {
                            3: {
                                100: 4,
                                120: 5,
                                140: 7,
                                160: 9,
                            },
                            4: {
                                100: 5,
                                120: 7,
                                140: 8,
                                160: 11,
                            },
                            5: {
                                100: 6,
                                120: 8,
                                140: 10,
                                160: 13,
                            },
                            6: {
                                100: 7,
                                120: 9,
                                140: 12,
                                160: 15,
                            },
                        },
                        50: {
                            3: {
                                100: 5,
                                120: 7,
                                140: 9,
                                160: 11,
                            },
                            4: {
                                100: 6,
                                120: 8,
                                140: 10,
                                160: 13,
                            },
                            5: {
                                100: 7,
                                120: 9,
                                140: 12,
                                160: 15,
                            },
                            6: {
                                100: 8,
                                120: 11,
                                140: 14,
                                160: 17,
                            },
                        },
                        55: {
                            3: {
                                100: 7,
                                120: 9,
                                140: 11,
                                160: 14,
                            },
                            4: {
                                100: 8,
                                120: 10,
                                140: 13,
                                160: 16,
                            },
                            5: {
                                100: 9,
                                120: 11,
                                140: 14,
                                160: 17,
                            },
                            6: {
                                100: 10,
                                120: 13,
                                140: 16,
                                160: 20,
                            },
                        },
                        60: {
                            3: {
                                100: 9,
                                120: 11,
                                140: 14,
                                160: 17,
                            },
                            4: {
                                100: 10,
                                120: 13,
                                140: 15,
                                160: 18,
                            },
                            5: {
                                100: 11,
                                120: 14,
                                140: 17,
                                160: 20,
                            },
                            6: {
                                100: 12,
                                120: 15,
                                140: 18,
                                160: 22,
                            },
                        },
                        65: {
                            3: {
                                100: 12,
                                120: 14,
                                140: 17,
                                160: 20,
                            },
                            4: {
                                100: 13,
                                120: 15,
                                140: 18,
                                160: 22,
                            },
                            5: {
                                100: 14,
                                120: 17,
                                140: 20,
                                160: 23,
                            },
                            6: {
                                100: 15,
                                120: 18,
                                140: 21,
                                160: 25,
                            },
                        },
                        70: {
                            3: {
                                100: 31,
                                120: 35,
                                140: 39,
                                160: 43,
                            },
                            4: {
                                100: 33,
                                120: 36,
                                140: 41,
                                160: 45,
                            },
                            5: {
                                100: 34,
                                120: 38,
                                140: 42,
                                160: 47,
                            },
                            6: {
                                100: 36,
                                120: 40,
                                140: 44,
                                160: 49,
                            },
                        },
                        75: {
                            3: {
                                100: 36,
                                120: 39,
                                140: 42,
                                160: 45,
                            },
                            4: {
                                100: 38,
                                120: 41,
                                140: 44,
                                160: 48,
                            },
                            5: {
                                100: 41,
                                120: 44,
                                140: 47,
                                160: 51,
                            },
                            6: {
                                100: 43,
                                120: 47,
                                140: 50,
                                160: 54,
                            },
                        },
                        80: {
                            3: {
                                100: 40,
                                120: 43,
                                140: 45,
                                160: 47,
                            },
                            4: {
                                100: 44,
                                120: 46,
                                140: 49,
                                160: 51,
                            },
                            5: {
                                100: 48,
                                120: 50,
                                140: 52,
                                160: 55,
                            },
                            6: {
                                100: 51,
                                120: 54,
                                140: 56,
                                160: 59,
                            },
                        },
                        85: {
                            3: {
                                100: 46,
                                120: 47,
                                140: 48,
                                160: 49,
                            },
                            4: {
                                100: 50,
                                120: 52,
                                140: 53,
                                160: 54,
                            },
                            5: {
                                100: 55,
                                120: 56,
                                140: 58,
                                160: 59,
                            },
                            6: {
                                100: 60,
                                120: 61,
                                140: 63,
                                160: 64,
                            },
                        },
                    },
                    'n': {
                        40: {
                            3: {
                                100: 2,
                                120: 2,
                                140: 3,
                                160: 4,
                            },
                            4: {
                                100: 2,
                                120: 3,
                                140: 4,
                                160: 5,
                            },
                            5: {
                                100: 2,
                                120: 3,
                                140: 4,
                                160: 6,
                            },
                            6: {
                                100: 3,
                                120: 4,
                                140: 5,
                                160: 7,
                            },
                        },
                        45: {
                            3: {
                                100: 2,
                                120: 3,
                                140: 4,
                                160: 5,
                            },
                            4: {
                                100: 3,
                                120: 4,
                                140: 5,
                                160: 6,
                            },
                            5: {
                                100: 3,
                                120: 4,
                                140: 5,
                                160: 7,
                            },
                            6: {
                                100: 4,
                                120: 5,
                                140: 6,
                                160: 8,
                            },
                        },
                        50: {
                            3: {
                                100: 3,
                                120: 4,
                                140: 5,
                                160: 7,
                            },
                            4: {
                                100: 4,
                                120: 5,
                                140: 6,
                                160: 8,
                            },
                            5: {
                                100: 4,
                                120: 5,
                                140: 7,
                                160: 9,
                            },
                            6: {
                                100: 5,
                                120: 6,
                                140: 8,
                                160: 10,
                            },
                        },
                        55: {
                            3: {
                                100: 4,
                                120: 5,
                                140: 7,
                                160: 9,
                            },
                            4: {
                                100: 5,
                                120: 6,
                                140: 8,
                                160: 10,
                            },
                            5: {
                                100: 6,
                                120: 7,
                                140: 9,
                                160: 11,
                            },
                            6: {
                                100: 6,
                                120: 8,
                                140: 10,
                                160: 12,
                            },
                        },
                        60: {
                            3: {
                                100: 6,
                                120: 7,
                                140: 9,
                                160: 11,
                            },
                            4: {
                                100: 7,
                                120: 8,
                                140: 10,
                                160: 12,
                            },
                            5: {
                                100: 7,
                                120: 9,
                                140: 11,
                                160: 13,
                            },
                            6: {
                                100: 8,
                                120: 10,
                                140: 12,
                                160: 15,
                            },
                        },
                        65: {
                            3: {
                                100: 8,
                                120: 10,
                                140: 12,
                                160: 14,
                            },
                            4: {
                                100: 9,
                                120: 11,
                                140: 13,
                                160: 15,
                            },
                            5: {
                                100: 10,
                                120: 12,
                                140: 14,
                                160: 17,
                            },
                            6: {
                                100: 10,
                                120: 13,
                                140: 15,
                                160: 18,
                            },
                        },
                        70: {
                            3: {
                                100: 25,
                                120: 28,
                                140: 32,
                                160: 35,
                            },
                            4: {
                                100: 26,
                                120: 30,
                                140: 33,
                                160: 37,
                            },
                            5: {
                                100: 28,
                                120: 31,
                                140: 35,
                                160: 39,
                            },
                            6: {
                                100: 29,
                                120: 33,
                                140: 36,
                                160: 40,
                            },
                        },
                        75: {
                            3: {
                                100: 31,
                                120: 34,
                                140: 37,
                                160: 40,
                            },
                            4: {
                                100: 33,
                                120: 36,
                                140: 39,
                                160: 42,
                            },
                            5: {
                                100: 36,
                                120: 39,
                                140: 42,
                                160: 45,
                            },
                            6: {
                                100: 38,
                                120: 41,
                                140: 44,
                                160: 48,
                            },
                        },
                        80: {
                            3: {
                                100: 38,
                                120: 40,
                                140: 42,
                                160: 44,
                            },
                            4: {
                                100: 41,
                                120: 43,
                                140: 46,
                                160: 48,
                            },
                            5: {
                                100: 45,
                                120: 47,
                                140: 49,
                                160: 52,
                            },
                            6: {
                                100: 48,
                                120: 51,
                                140: 53,
                                160: 56,
                            },
                        },
                        85: {
                            3: {
                                100: 46,
                                120: 47,
                                140: 48,
                                160: 49,
                            },
                            4: {
                                100: 50,
                                120: 52,
                                140: 53,
                                160: 54,
                            },
                            5: {
                                100: 55,
                                120: 56,
                                140: 58,
                                160: 59,
                            },
                            6: {
                                100: 60,
                                120: 61,
                                140: 63,
                                160: 64,
                            },
                        },
                    }
                },
                'f': {
                    'y': {
                        40: {
                            3: {
                                100: 2,
                                120: 3,
                                140: 3,
                                160: 5,
                            },
                            4: {
                                100: 2,
                                120: 3,
                                140: 4,
                                160: 5,
                            },
                            5: {
                                100: 2,
                                120: 3,
                                140: 5,
                                160: 6,
                            },
                            6: {
                                100: 3,
                                120: 4,
                                140: 5,
                                160: 7,
                            },
                        },
                        45: {
                            3: {
                                100: 3,
                                120: 3,
                                140: 5,
                                160: 6,
                            },
                            4: {
                                100: 3,
                                120: 4,
                                140: 5,
                                160: 7,
                            },
                            5: {
                                100: 3,
                                120: 4,
                                140: 6,
                                160: 8,
                            },
                            6: {
                                100: 4,
                                120: 5,
                                140: 6,
                                160: 9,
                            },
                        },
                        50: {
                            3: {
                                100: 3,
                                120: 5,
                                140: 6,
                                160: 8,
                            },
                            4: {
                                100: 4,
                                120: 5,
                                140: 6,
                                160: 8,
                            },
                            5: {
                                100: 4,
                                120: 6,
                                140: 7,
                                160: 9,
                            },
                            6: {
                                100: 5,
                                120: 6,
                                140: 8,
                                160: 10,
                            },
                        },
                        55: {
                            3: {
                                100: 5,
                                120: 6,
                                140: 8,
                                160: 10,
                            },
                            4: {
                                100: 5,
                                120: 7,
                                140: 8,
                                160: 11,
                            },
                            5: {
                                100: 6,
                                120: 7,
                                140: 9,
                                160: 11,
                            },
                            6: {
                                100: 6,
                                120: 8,
                                140: 10,
                                160: 12,
                            },
                        },
                        60: {
                            3: {
                                100: 6,
                                120: 8,
                                140: 10,
                                160: 12,
                            },
                            4: {
                                100: 7,
                                120: 9,
                                140: 11,
                                160: 13,
                            },
                            5: {
                                100: 7,
                                120: 9,
                                140: 11,
                                160: 14,
                            },
                            6: {
                                100: 8,
                                120: 10,
                                140: 12,
                                160: 15,
                            },
                        },
                        65: {
                            3: {
                                100: 9,
                                120: 10,
                                140: 13,
                                160: 15,
                            },
                            4: {
                                100: 9,
                                120: 11,
                                140: 13,
                                160: 16,
                            },
                            5: {
                                100: 9,
                                120: 12,
                                140: 14,
                                160: 17,
                            },
                            6: {
                                100: 10,
                                120: 12,
                                140: 15,
                                160: 18,
                            },
                        },
                        70: {
                            3: {
                                100: 34,
                                120: 39,
                                140: 43,
                                160: 48,
                            },
                            4: {
                                100: 36,
                                120: 40,
                                140: 44,
                                160: 49,
                            },
                            5: {
                                100: 37,
                                120: 41,
                                140: 46,
                                160: 51,
                            },
                            6: {
                                100: 38,
                                120: 43,
                                140: 47,
                                160: 52,
                            },
                        },
                        75: {
                            3: {
                                100: 42,
                                120: 46,
                                140: 49,
                                160: 53,
                            },
                            4: {
                                100: 43,
                                120: 47,
                                140: 51,
                                160: 55,
                            },
                            5: {
                                100: 44,
                                120: 48,
                                140: 52,
                                160: 56,
                            },
                            6: {
                                100: 46,
                                120: 49,
                                140: 53,
                                160: 58,
                            },
                        },
                        80: {
                            3: {
                                100: 50,
                                120: 53,
                                140: 56,
                                160: 59,
                            },
                            4: {
                                100: 51,
                                120: 54,
                                140: 57,
                                160: 60,
                            },
                            5: {
                                100: 53,
                                120: 56,
                                140: 59,
                                160: 62,
                            },
                            6: {
                                100: 54,
                                120: 57,
                                140: 60,
                                160: 63,
                            },
                        },
                        85: {
                            3: {
                                100: 59,
                                120: 61,
                                140: 63,
                                160: 65,
                            },
                            4: {
                                100: 60,
                                120: 62,
                                140: 64,
                                160: 66,
                            },
                            5: {
                                100: 61,
                                120: 63,
                                140: 65,
                                160: 67,
                            },
                            6: {
                                100: 63,
                                120: 65,
                                140: 66,
                                160: 68,
                            },
                        },
                    },
                    'n': {
                        40: {
                            3: {
                                100: 1,
                                120: 1,
                                140: 1,
                                160: 2,
                            },
                            4: {
                                100: 1,
                                120: 1,
                                140: 2,
                                160: 2,
                            },
                            5: {
                                100: 1,
                                120: 1,
                                140: 2,
                                160: 3,
                            },
                            6: {
                                100: 1,
                                120: 2,
                                140: 2,
                                160: 3,
                            },
                        },
                        45: {
                            3: {
                                100: 1,
                                120: 2,
                                140: 2,
                                160: 3,
                            },
                            4: {
                                100: 1,
                                120: 2,
                                140: 2,
                                160: 3,
                            },
                            5: {
                                100: 1,
                                120: 2,
                                140: 3,
                                160: 3,
                            },
                            6: {
                                100: 2,
                                120: 2,
                                140: 3,
                                160: 4,
                            },
                        },
                        50: {
                            3: {
                                100: 2,
                                120: 2,
                                140: 3,
                                160: 4,
                            },
                            4: {
                                100: 2,
                                120: 2,
                                140: 3,
                                160: 4,
                            },
                            5: {
                                100: 2,
                                120: 3,
                                140: 4,
                                160: 5,
                            },
                            6: {
                                100: 2,
                                120: 3,
                                140: 4,
                                160: 5,
                            },
                        },
                        55: {
                            3: {
                                100: 3,
                                120: 3,
                                140: 4,
                                160: 5,
                            },
                            4: {
                                100: 3,
                                120: 3,
                                140: 4,
                                160: 6,
                            },
                            5: {
                                100: 3,
                                120: 4,
                                140: 5,
                                160: 6,
                            },
                            6: {
                                100: 3,
                                120: 4,
                                140: 5,
                                160: 7,
                            },
                        },
                        60: {
                            3: {
                                100: 4,
                                120: 5,
                                140: 6,
                                160: 7,
                            },
                            4: {
                                100: 4,
                                120: 5,
                                140: 6,
                                160: 8,
                            },
                            5: {
                                100: 4,
                                120: 5,
                                140: 7,
                                160: 8,
                            },
                            6: {
                                100: 5,
                                120: 6,
                                140: 7,
                                160: 9,
                            },
                        },
                        65: {
                            3: {
                                100: 5,
                                120: 7,
                                140: 8,
                                160: 10,
                            },
                            4: {
                                100: 6,
                                120: 7,
                                140: 9,
                                160: 10,
                            },
                            5: {
                                100: 6,
                                120: 7,
                                140: 9,
                                160: 11,
                            },
                            6: {
                                100: 6,
                                120: 8,
                                140: 9,
                                160: 12,
                            },
                        },
                        70: {
                            3: {
                                100: 26,
                                120: 29,
                                140: 33,
                                160: 37,
                            },
                            4: {
                                100: 27,
                                120: 30,
                                140: 34,
                                160: 38,
                            },
                            5: {
                                100: 28,
                                120: 31,
                                140: 35,
                                160: 39,
                            },
                            6: {
                                100: 29,
                                120: 32,
                                140: 36,
                                160: 41,
                            },
                        },
                        75: {
                            3: {
                                100: 34,
                                120: 37,
                                140: 41,
                                160: 44,
                            },
                            4: {
                                100: 35,
                                120: 39,
                                140: 42,
                                160: 46,
                            },
                            5: {
                                100: 36,
                                120: 40,
                                140: 43,
                                160: 47,
                            },
                            6: {
                                100: 37,
                                120: 41,
                                140: 45,
                                160: 48,
                            },
                        },
                        80: {
                            3: {
                                100: 44,
                                120: 47,
                                140: 50,
                                160: 53,
                            },
                            4: {
                                100: 45,
                                120: 48,
                                140: 51,
                                160: 54,
                            },
                            5: {
                                100: 47,
                                120: 49,
                                140: 52,
                                160: 55,
                            },
                            6: {
                                100: 48,
                                120: 51,
                                140: 54,
                                160: 57,
                            },
                        },
                        85: {
                            3: {
                                100: 56,
                                120: 58,
                                140: 60,
                                160: 62,
                            },
                            4: {
                                100: 57,
                                120: 59,
                                140: 61,
                                160: 63,
                            },
                            5: {
                                100: 58,
                                120: 60,
                                140: 62,
                                160: 64,
                            },
                            6: {
                                100: 60,
                                120: 61,
                                140: 63,
                                160: 65,
                            },
                        },
                    },
                },
            };
            let data_younger_40 = {
                'y': {
                    4: {
                        120: 2,
                        140: 3,
                        160: 4,
                        180: 6,
                    },
                    5: {
                        120: 2,
                        140: 3,
                        160: 5,
                        180: 7,
                    },
                    6: {
                        120: 3,
                        140: 4,
                        160: 6,
                        180: 8,
                    },
                    7: {
                        120: 3,
                        140: 5,
                        160: 7,
                        180: 10,
                    },
                    8: {
                        120: 4,
                        140: 6,
                        160: 8,
                        180: 12,
                    },
                },
                'n': {
                    4: {
                        120: 1,
                        140: 1,
                        160: 2,
                        180: 3,
                    },
                    5: {
                        120: 1,
                        140: 2,
                        160: 3,
                        180: 3,
                    },
                    6: {
                        120: 1,
                        140: 2,
                        160: 3,
                        180: 4,
                    },
                    7: {
                        120: 2,
                        140: 2,
                        160: 4,
                        180: 5,
                    },
                },
            };

            if (age < 40) {
                if (cholesterol > 7 && smoking === 'n') {
                    cholesterol = 7;
                }
                if (cholesterol > 8 && smoking === 'y') {
                    cholesterol = 8;
                }
                if (cholesterol < 4) {
                    cholesterol = 4;
                }
                if (pressure < 120) {
                    pressure = 120;
                }
                if (smoking in data_younger_40) {
                    if (cholesterol in data_younger_40[smoking]) {
                        if (pressure in data_younger_40[smoking][cholesterol]) {
                            result = data_younger_40[smoking][cholesterol][pressure]
                        }
                    }
                }
            } else {
                if (pressure > 160) {
                    pressure = 160;
                }
                if (cholesterol > 6) {
                    cholesterol = 6;
                }
                if (gender in data) {
                    if (smoking in data[gender]) {
                        if (age in data[gender][smoking]) {
                            if (cholesterol in data[gender][smoking][age]) {
                                if (pressure in data[gender][smoking][age][cholesterol]) {
                                    result = data[gender][smoking][age][cholesterol][pressure];
                                }
                            }
                        }
                    }
                }
            }
            if (!result) {
                result = 0;
            }

            this.user.score = result;
            return result;
        }
    },
}
</script>

<template>
    <div class="component-health-recommendation-module">
        <div class="container">
            <div class="content">
                <h1 class="title">Расчет рекомендаций алгоритма выдачи заключений профпатологам</h1>
                <div class="body body-block-start" v-if="this.template ===''">
                    <div class="block-form">
                        <h2 class="block-form-title">Для расчета введите персональные данные</h2>
                        <div class="block-form-columns">
                            <div class="column">
                                <div class="block-fio">
                                    <h3 class="title">ФИО</h3>
                                    <div class="input">
                                        <input type="text" name="fio" placeholder="ФИО" v-model="this.user.fio">
                                    </div>
                                </div>
                                <div class="block-date" id="block-date">
                                    <h3 class="title">Дата рождения</h3>
                                    <div class="input">
                                        <input type="date" name="date" v-model="this.user.birthdate">
                                    </div>
                                </div>
                                <div class="block-gender" id="block-gender">
                                    <h3 class="title">Пол</h3>
                                    <div class="radio">
                                        <input type="radio" name="gender" id="male" v-model="this.user.gender"
                                               value="m">
                                        <label for="male" class="appearance"></label>
                                        <label for="male">Муж</label>
                                        <input type="radio" name="gender" id="female" v-model="this.user.gender"
                                               value="f">
                                        <label for="female" class="appearance"></label>
                                        <label for="female">Жен</label>
                                    </div>
                                </div>
                                <div class="block-position">
                                    <h3 class="title">Должность</h3>
                                    <div class="input">
                                        <input type="text" name="position" v-model="this.user.position">
                                    </div>
                                </div>
                                <div class="block-points">
                                    <h3 class="title">Пункты приказа при МО</h3>
                                    <div>
                                        <multiselect
                                            v-model="this.user.points"
                                            tag-placeholder="Add this as new tag"
                                            placeholder="Поиск вредного фактора"
                                            label="name"
                                            track-by="number"
                                            :options="order_points"
                                            :multiple="true"
                                            :taggable="true"
                                            @tag="addTag"
                                        ></multiselect>

                                    </div>
                                </div>
                                <div class="block-diagnose-list">
                                    <h3 class="title">Список диагнозов, выявленных в ходе МО</h3>
                                    <div class="diagnose-list">
                                        <template v-if="this.diagnoses_count">
                                            <div class="" v-for="(item, index) in this.diagnoses_count" :key="index">
                                                <multiselect
                                                    v-model="this.user.selected_diagnoses[index]"
                                                    :options="diagnoses"
                                                    placeholder="Поиск диагноза"
                                                    label="name"
                                                    track-by="name"
                                                ></multiselect>
                                            </div>
                                        </template>
                                        <div class="diagnose-add">
                                            <div @click="add_diagnose()">Добавить диагноз</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="block-pressure" id="block-pressure">
                                    <h3 class="title">Уровень систолического (верхнего АД)</h3>
                                    <div class="input">
                                        <input type="text" name="pressure" placeholder="Уровень верхнего АД"
                                               v-model="this.user.pressure">
                                    </div>
                                </div>
                                <div class="block-smoking" id="block-smoking">
                                    <h3 class="title">Курение</h3>
                                    <div class="radio">
                                        <input type="radio" name="smoking" id="smoking-y" v-model="this.user.smoking"
                                               value="y">
                                        <label for="smoking-y" class="appearance"></label>
                                        <label for="smoking-y">Да</label>
                                        <input type="radio" name="smoking" id="smoking-n" v-model="this.user.smoking"
                                               value="n">
                                        <label for="smoking-n" class="appearance"></label>
                                        <label for="smoking-n">Нет</label>
                                    </div>
                                </div>
                                <div class="block-cholesterol" id="block-cholesterol">
                                    <h3 class="title">Уровень холестерина в крови, ммоль/литр</h3>
                                    <div class="input">
                                        <input type="text" name="cholesterol" placeholder="Уровень холестерина в крови"
                                               v-model="this.user.cholesterol">
                                    </div>
                                </div>
                                <div class="block-contraindications">
                                    <h3 class="title">Список противопоказаний, выявленных в ходе МО, если есть</h3>
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               name="contraindications"
                                               id="contraindications"
                                               v-model="this.user.is_contraindications"
                                               :checked="this.user.is_contraindications">
                                        <label for="contraindications" class="appearance"></label>
                                        <label for="contraindications">противопоказания отсутствуют</label>
                                    </div>
                                    <div class="input" v-if="!this.user.is_contraindications">
                                        <input type="text" name="contraindications"
                                               placeholder="Введите противопоказания">
                                    </div>
                                </div>
                                <div class="block-buttons">
                                    <div class="button" @click="get_recommendations()">Получить рекомендации</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="image">
                        <img
                            src="https://storage.yandexcloud.net/storage.inspectrum.ru/inspectrum-clinic/backgrounds/health-recommendation-module-1.png"
                            alt="health-recommendation-module-1.png">
                    </div>
                </div>
                <div class="body body-block-end" v-if="this.template ==='result'">
                    <div class="block-form">
                        <div class="title">
                            <div class="button-back"></div>
                            <h2 class="block-form-title">Рекомендации алгоритма:</h2>
                        </div>
                        <div class="block-recommendation">
                            <div class="title">{{ this.recommendations.disp_group }}</div>
                            <div class="text">{{ this.recommendations.disp_recomendation }}</div>
                        </div>
                        <div class="block-recommendation">
                            <div class="title">{{ this.recommendations.prof_group }}</div>
                            <div class="text">{{ this.recommendations.prof_recomendation }}</div>
                        </div>
                        <div class="block-buttons">
                            <div class="button-new" @click="back_to_start()">Расчет новой рекомендации</div>
                            <div class="button-back" @click="back_to_start()">Назад</div>
                        </div>
                    </div>
                    <div class="image">
                        <img
                            src="https://storage.yandexcloud.net/storage.inspectrum.ru/inspectrum-clinic/backgrounds/health-recommendation-module-2.png"
                            alt="health-recommendation-module-2.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.component-health-recommendation-module {

    > .container {
        width: 100%;
        max-width: $bp-xxl;
        margin: 0 auto;
        border-radius: 10px;

        @media (max-width: 1520px) {
            max-width: calc(100% - 120px);
        }
        @media (max-width: $bp-xl) {
            max-width: calc(100% - 40px);
        }

        @media (max-width: $bp-ssm) {
            max-width: 100%;
            border-radius: unset;
        }

        > .content {
            display: flex;
            flex-direction: column;

            > .title {
                width: 100%;
                max-width: 580px;
                font-size: 2.2rem;
                font-weight: normal;
            }

            > .body {
                background-color: #F7F9FC;
                border-radius: 35px;
                padding: 60px;
                margin: 20px 0 50px 0;

            }

            > .body-block-start, > .body-block-end {
                display: flex;
                gap: 50px;

                > .block-form {
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    gap: 20px;

                    > .block-form-title {
                        font-size: 1.5rem;
                        font-weight: normal;
                    }

                    > .block-form-columns {
                        display: flex;
                        gap: 20px;

                        > .column {
                            width: 50%;
                            max-width: 320px;
                            display: flex;
                            flex-direction: column;
                            gap: 10px;

                            > .block-fio, > .block-position, > .block-pressure, > .block-cholesterol, > .block-contraindications {
                                width: 100%;
                                display: flex;
                                flex-direction: column;
                                gap: 5px;

                                > .title {
                                    font-size: 1rem;
                                    font-weight: normal;
                                }

                                > .input {
                                    height: 40px;
                                    width: 100%;
                                    border-radius: 10px;
                                    border: 1px solid #E4E9F2;
                                    overflow: hidden;

                                    > input {
                                        height: 100%;
                                        width: 100%;
                                        border: none;
                                        padding: 0 0 0 10px;

                                        &::placeholder {
                                            color: #8F9BB3;
                                            font-size: 1rem;
                                            font-weight: normal;
                                        }
                                    }
                                }
                            }

                            > .block-date {
                                width: 100%;
                                display: flex;
                                flex-direction: column;
                                gap: 5px;

                                > .title {
                                    font-size: 1rem;
                                    font-weight: normal;
                                }

                                > .input {
                                    height: 40px;
                                    width: 100%;
                                    border-radius: 10px;
                                    border: 1px solid #E4E9F2;
                                    overflow: hidden;

                                    > input {
                                        height: 100%;
                                        width: 100%;
                                        border: none;
                                        padding: 0 10px 0 10px;

                                        &::placeholder {
                                            color: #8F9BB3;
                                            font-size: 1rem;
                                            font-weight: normal;
                                        }
                                    }
                                }
                            }

                            > .block-gender, > .block-smoking {
                                width: 100%;
                                display: flex;
                                flex-direction: column;
                                gap: 5px;

                                > .title {
                                    font-size: 1rem;
                                    font-weight: normal;
                                }

                                > .radio {
                                    display: flex;
                                    justify-content: flex-start;
                                    align-items: center;
                                    gap: 10px;
                                    height: 40px;

                                    > label {
                                        font-size: 1rem;
                                        font-weight: normal;
                                    }

                                    > input {
                                        height: 20px;
                                        width: 20px;
                                        min-width: 20px;
                                        //appearance: auto;
                                        display: none;

                                        &:checked {
                                            + .appearance {
                                                background-color: $color-primary;
                                            }
                                        }
                                    }

                                    > .appearance {
                                        height: 20px;
                                        width: 20px;
                                        min-width: 20px;
                                        border-radius: 5px;
                                        border: 1px solid #E4E9F2;
                                    }
                                }
                            }

                            > .block-points, > .block-diagnose-list {
                                width: 100%;
                                display: flex;
                                flex-direction: column;
                                gap: 5px;

                                > .title {
                                    font-size: 1rem;
                                    font-weight: normal;
                                }

                                > .select {
                                    height: 40px;
                                    width: 100%;
                                    border-radius: 10px;
                                    border: 1px solid #E4E9F2;
                                    overflow: hidden;

                                    > select {
                                        height: 100%;
                                        width: 100%;
                                        border: none;
                                        padding: 0 10px 0 10px;

                                        &::placeholder {
                                            color: #8F9BB3;
                                            font-size: 1rem;
                                            font-weight: normal;
                                        }

                                        > option {
                                            height: 30px;
                                        }
                                    }
                                }

                                > .diagnose-list {
                                    width: 100%;
                                    display: flex;
                                    flex-direction: column;
                                    gap: 10px;

                                    > .diagnose {
                                        height: 40px;
                                        width: 100%;
                                        border-radius: 10px;
                                        border: 1px solid #E4E9F2;
                                        overflow: hidden;

                                        > select {
                                            height: 100%;
                                            width: 100%;
                                            border: none;
                                            padding: 0 10px 0 10px;

                                            &::placeholder {
                                                color: #8F9BB3;
                                                font-size: 1rem;
                                                font-weight: normal;
                                            }

                                            > option {
                                                height: 30px;
                                            }
                                        }
                                    }

                                    > .diagnose-add {
                                        display: flex;
                                        justify-content: center;
                                        margin: 10px 0 0 0;

                                        > div {
                                            color: #008EEB;
                                            cursor: pointer;
                                            transition: $transition;

                                            &:hover {
                                                color: $color-primary;
                                            }
                                        }
                                    }
                                }

                                > .input-list {
                                    height: 40px;
                                    width: 100%;
                                    border-radius: 10px;
                                    border: 1px solid #E4E9F2;
                                    overflow: hidden;

                                    > input {
                                        height: 100%;
                                        width: 100%;
                                        border: none;
                                        padding: 0 10px 0 10px;
                                    }

                                    > datalist {
                                        background-color: silver;

                                        > option {
                                            height: 40px;
                                        }
                                    }
                                }
                            }

                            > .block-contraindications {
                                width: 100%;
                                display: flex;
                                flex-direction: column;
                                gap: 5px;

                                > .title {
                                    font-size: 1rem;
                                    font-weight: normal;
                                }

                                > .input {
                                    height: 40px;
                                    width: 100%;
                                    border-radius: 10px;
                                    border: 1px solid #E4E9F2;
                                    overflow: hidden;

                                    > input {
                                        height: 100%;
                                        width: 100%;
                                        border: none;
                                        padding: 0 0 0 10px;

                                        &::placeholder {
                                            color: #8F9BB3;
                                            font-size: 1rem;
                                            font-weight: normal;
                                        }
                                    }
                                }

                                > .checkbox {
                                    display: flex;
                                    justify-content: flex-start;
                                    align-items: center;
                                    gap: 10px;
                                    height: 40px;

                                    > label {
                                        font-size: 1rem;
                                        font-weight: normal;
                                    }

                                    > input {
                                        height: 20px;
                                        width: 20px;
                                        min-width: 20px;
                                        //appearance: auto;
                                        display: none;

                                        &:checked {
                                            + .appearance {
                                                background-color: $color-primary;
                                            }
                                        }
                                    }

                                    > .appearance {
                                        height: 20px;
                                        width: 20px;
                                        min-width: 20px;
                                        border-radius: 5px;
                                        border: 1px solid #E4E9F2;
                                    }
                                }
                            }

                            > .block-buttons {
                                > .button {
                                    height: 40px;
                                    width: 100%;
                                    border-radius: 10px;
                                    background-color: $color-primary;
                                    color: $color-alter;
                                    transition: $transition;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    cursor: pointer;
                                    font-weight: 500;

                                    &:hover {
                                        background-color: $color-primary-darken;
                                    }

                                }
                            }

                            > .error {
                                > .title {
                                    color: $color-primary;
                                }
                            }
                        }
                    }

                    > .title {
                        display: flex;
                        gap: 10px;

                        > .button-back {
                            height: 20px;
                            width: 20px;
                            min-width: 20px;
                        }

                        > .block-form-title {
                            font-size: 1.5rem;
                            font-weight: normal;
                        }
                    }

                    > .block-recommendation {
                        margin: 50px 0 0 0;
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                        width: 100%;
                        max-width: 500px;

                        > .title {
                            font-size: 1.2rem;
                            color: #9F60F6;
                        }

                        > .text {
                            width: 100%;
                            background-color: rgba(159, 96, 246, 0.1);
                            border-radius: 5px;
                            padding: 10px;
                        }
                    }

                    > .block-buttons {
                        display: flex;
                        flex-direction: column;
                        gap: 20px;

                        > .button-new {
                            height: 40px;
                            width: 100%;
                            max-width: 500px;
                            border-radius: 10px;
                            background-color: $color-primary;
                            color: $color-alter;
                            transition: $transition;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            cursor: pointer;
                            font-weight: 500;

                            &:hover {
                                background-color: $color-primary-darken;
                            }
                        }

                        > .button-back {
                            height: 40px;
                            width: 100%;
                            max-width: 500px;
                            border-radius: 10px;
                            border: 2px solid $color-primary;
                            transition: $transition;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            cursor: pointer;
                            font-weight: 500;

                            &:hover {
                                background-color: $color-primary-darken;
                                color: $color-alter;
                            }
                        }
                    }
                }

                > .image {
                    width: 100%;
                    max-width: 500px;
                    display: flex;
                    //justify-content: flex-end;
                    align-items: center;
                    overflow: hidden;

                    > img {
                        height: 100%;
                        //width: 100%;
                        object-fit: contain;
                    }
                }
            }
        }
    }
}
</style>
