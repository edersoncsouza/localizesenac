
$(document).ready(function() {
    // Generate a simple captcha
    function randomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    };
    $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

    $('#formCadastraAluno, #formAddNewRow').formValidation({
        message: 'Este não é um valor válido',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            matricula: {
                //row: '.col-sm-4',
                validators: {
                    notEmpty: {
                        message: 'A matrícula é obrigatória'
                    },
					stringLength: {
                        min: 4,
                        max: 30,
                        message: 'A matrícula deve ter no mínimo 4 e no máximo 30 caracteres'
                    },
					regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'A matrícula pode ter apenas caracteres alfabéticos, números, ponto e sublinha'
                    }
                }
            },
			password: {
                validators: {
                    notEmpty: {
                        message: 'A senha é obrigatória'
                    },
					stringLength: {
                        min: 6,
                        max: 30,
                        message: 'A senha deve ter no mínimo 6 e no máximo 30 caracteres'
                    },
                    different: {
                        field: 'matricula',
                        message: 'A senha não pode ser igual a matrícula'
                    },
					regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'A senha pode ter apenas caracteres alfabéticos, números, ponto e sublinha'
                    }
                }
            },
			password2: {
                validators: {
                    notEmpty: {
                        message: 'A confirmação de senha é obrigatória'
                    },
					stringLength: {
                        min: 6,
                        max: 30,
                        message: 'A senha deve ter no mínimo 6 e no máximo 30 caracteres'
                    },
                    identical: {
                        field: 'password',
                        message: 'A confirmação deve ser igual a senha'
                    }
                }
            },
			nome: {
                //row: '.col-sm-4',
                validators: {
                    notEmpty: {
                        message: 'O nome é obrigatório'
                    },
					stringLength: {
                        min: 6,
                        max: 30,
                        message: 'O nome deve ter no mínimo 6 e no máximo 30 caracteres'
                    },
					regexp: {
                        regexp: /^[a-zA-Z\s]+$/i,
                        message: 'O nome pode ter apenas caracteres alfabéticos e espaços'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'O E-mail é obrigatório'
                    },
                    emailAddress: {
                        message: 'A entrada não é um E-mail válido'
                    }
                }
            },
            confirmaEmail: {
                validators: {
                    notEmpty: {
                        message: 'A confirmação de E-mail é obrigatória'
                    },
                    emailAddress: {
                        message: 'A entrada não é um E-mail válido'
                    },
                    identical: {
                        field: 'email',
                        message: 'A confirmação deve ser igual ao E-mail'
                    }
                }
            },
			celular: {
                validators: {
                    notEmpty: {
                        message: 'O celular é obrigatório'
                    },
					stringLength: {
                        min: 10,
                        max: 11,
                        message: 'O celular deve ser digitado com DDD e seus 8 ou 9 dígitos'
                    },
					regexp: {
                        regexp: /^\(\d{2}\)\s\d{4}[-]\d{4}[_\d]+$/, // thanx http://www.regexr.com/
                        message: 'O celular deve ser digitado com DDD e seus 8 ou 9 dígitos'
                    }
                }
            },
            ativo: {
                validators: {
                    notEmpty: {
                        message: 'O status de ativação é obrigatório'
                    }
                }
            },
            captcha: {
                validators: {
                    callback: {
                        message: 'Wrong answer',
                        callback: function(value, validator, $field) {
                            var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                            return value == sum;
                        }
                    }
                }
            },
            agree: {
                validators: {
                    notEmpty: {
                        message: 'You must agree with the terms and conditions'
                    }
                }
            }
        }
    });

	$('#formAddNewRow').formValidation({
    	excluded: [':disabled'],
		message: 'Este não é um valor válido',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
			horaInicio: {
				validators: {
					notEmpty: {
						message: 'O horário é obrigatório'
					}
				}
			}
			
		}
    });
	
	
	    $('#formMudaSenha, #formMudaInfo').formValidation({
        		excluded: [':disabled'],
		message: 'Este não é um valor válido',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
			passwordAtual: {
                validators: {
                    notEmpty: {
                        message: 'A senha é obrigatória'
                    },
					stringLength: {
                        min: 6,
                        max: 30,
                        message: 'A senha deve ter no mínimo 6 e no máximo 30 caracteres'
                    },
                    different: {
                        field: 'matricula',
                        message: 'A senha não pode ser igual a matrícula'
                    },
					regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'A senha pode ter apenas caracteres alfabéticos, números, ponto e sublinha'
                    }
                }
            },
			password: {
                validators: {
                    notEmpty: {
                        message: 'A senha é obrigatória'
                    },
					stringLength: {
                        min: 6,
                        max: 30,
                        message: 'A senha deve ter no mínimo 6 e no máximo 30 caracteres'
                    },
                    different: {
                        field: 'matricula',
                        message: 'A senha não pode ser igual a matrícula'
                    },
					regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'A senha pode ter apenas caracteres alfabéticos, números, ponto e sublinha'
                    }
                }
            },
			password2: {
                validators: {
                    notEmpty: {
                        message: 'A confirmação de senha é obrigatória'
                    },
					stringLength: {
                        min: 6,
                        max: 30,
                        message: 'A senha deve ter no mínimo 6 e no máximo 30 caracteres'
                    },
                    identical: {
                        field: 'password',
                        message: 'A confirmação deve ser igual a senha'
                    }
                }
            },
			nome: {
                //row: '.col-sm-4',
                validators: {
                    notEmpty: {
                        message: 'O nome é obrigatório'
                    },
					stringLength: {
                        min: 6,
                        max: 30,
                        message: 'O nome deve ter no mínimo 6 e no máximo 30 caracteres'
                    },
					regexp: {
                        regexp: /^[a-zA-Z\s]+$/i,
                        message: 'O nome pode ter apenas caracteres alfabéticos e espaços'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'O E-mail é obrigatório'
                    },
                    emailAddress: {
                        message: 'A entrada não é um E-mail válido'
                    }
                }
            },
            confirmaEmail: {
                validators: {
                    notEmpty: {
                        message: 'A confirmação de E-mail é obrigatória'
                    },
                    emailAddress: {
                        message: 'A entrada não é um E-mail válido'
                    },
                    identical: {
                        field: 'email',
                        message: 'A confirmação deve ser igual ao E-mail'
                    }
                }
            },
			celular: {
                validators: {
                    notEmpty: {
                        message: 'O celular é obrigatório'
                    },
					stringLength: {
                        min: 10,
                        max: 11,
                        message: 'O celular deve ser digitado com DDD e seus 8 ou 9 dígitos'
                    },
					regexp: {
                        regexp: /^\(\d{2}\)\s\d{4}[-]\d{4}[_\d]+$/, // thanx http://www.regexr.com/
                        message: 'O celular deve ser digitado com DDD e seus 8 ou 9 dígitos'
                    }
                }
            },
            ativo: {
                validators: {
                    notEmpty: {
                        message: 'O status de ativação é obrigatório'
                    }
                }
            },
            captcha: {
                validators: {
                    callback: {
                        message: 'Wrong answer',
                        callback: function(value, validator, $field) {
                            var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                            return value == sum;
                        }
                    }
                }
            },
            agree: {
                validators: {
                    notEmpty: {
                        message: 'You must agree with the terms and conditions'
                    }
                }
            }
        }
    });
	
});
