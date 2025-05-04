import './bootstrap';
import iconSetter from "../../Lareon/CMS/resources/js/icon.js";


// Success and error alerts using Swal
function responseAlert(title, type, timer = 5000) {
    //await Swal.fire({title, type, timer});
}

// comment part //
class CommentReplyHandler {
    static #selectors = {
        commentBtn: '.reply_comment_btn',
        modal: '#comment_modal',
        commentParent: '.comment_parent',
        commentAvatar: '.comment_avatar',
        commentAuthor: '.comment_author',
        commentMessage: '.comment_message',
        replyAvatar: '#replyToAvatar',
        replyAuthor: '#replyToAuthor',
        replyMessage: '#replyToMessage'
    };

    static init() {
        const buttons = document.querySelectorAll(this.#selectors.commentBtn);
        const modal = document.querySelector(this.#selectors.modal);

        if (!modal) return;

        buttons.forEach(btn =>
            btn.addEventListener('click', e => this.handleReplyClick(btn, modal))
        );
    }

    static handleReplyClick(btn, modal) {
        const parentId = btn.dataset.comment;
        const commentBoxId = btn.dataset.iteration;

        // Update parent input
        modal.querySelector(this.#selectors.commentParent).value = parentId;

        // Get comment data
        const commentBox = document.getElementById(commentBoxId);
        const {src: avatarSrc} = commentBox.querySelector(this.#selectors.commentAvatar);
        const author = commentBox.querySelector(this.#selectors.commentAuthor).textContent;
        const message = commentBox.querySelector(this.#selectors.commentMessage).innerHTML;

        // Update modal content
        const avatarModal = modal.querySelector(this.#selectors.replyAvatar);
        const authorModal = modal.querySelector(this.#selectors.replyAuthor);
        const messageModal = modal.querySelector(this.#selectors.replyMessage);

        avatarModal.src = avatarSrc;
        avatarModal.alt = author;
        authorModal.textContent = author;
        messageModal.innerHTML = message;
    }
}

// Form //
const FormHandler = {
    // Constants
    MESSAGES: {
        success: 'با موفقیت انجام شد',
        validationError: 'موارد مورد نیاز را به درستی وارد کنید',
        serverError: 'در فرآیند ثبت درخواست شما مشکلی به‌وجود آمده‌است، لطفا بعدا تلاش کنید',
        successSchema: 'فرم با موفقیت ثبت شد'
    },

    // Initialize form handling
    init() {
        this.bindFormEvents();
    },

    // Bind events to all forms
    bindFormEvents() {
        const ajaxForms = document.querySelectorAll('.formMode');
        ajaxForms.forEach(form => {
            const handler = this.handleSubmit.bind(this);
            form.addEventListener('submit', handler);
            form._submitHandler = handler;
        });
    },

    // Clean up event listeners
    cleanup() {
        const ajaxForms = document.querySelectorAll('.formMode');
        ajaxForms.forEach(form => {
            if (form._submitHandler) {
                form.removeEventListener('submit', form._submitHandler);
                delete form._submitHandler;
            }
        });
    },

    // Handle form submission
    async handleSubmit(event) {
        event.preventDefault();
        const form = event.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        this.setButtonState(submitBtn, true, 'wait ...');
        const responseEl = this.createResponseElement(form);

        try {
            responseEl.textContent = 'please wait';
            await this.submitForm(form, responseEl);
            this.handleSuccess(form, responseEl);
        } catch (error) {
            this.handleError(form, responseEl, error);
        } finally {
            this.setButtonState(submitBtn, false, originalBtnText);
            const captchaImgEl = form.querySelector('.recaptcha-image');
            if (captchaImgEl) {
                captchaImgEl.src = await new RecaptchaHandler().fetchNewCaptcha();
            }
        }
    },

    // Modify URL with prefix
    modifyUrl(url, prefix = 'ajax') {
        const urlObj = new URL(url);
        urlObj.pathname = `/${prefix}${urlObj.pathname}`;
        return urlObj.toString();
    },

    // Submit form via AJAX
    async submitForm(form, responseEl) {
        const destination = this.modifyUrl(form.action);
        const formData = new FormData(form);
        const response = await axios.post(destination, formData);
        return response.data;
    },

    // Set button state
    setButtonState(button, isDisabled, text) {
        button.innerHTML = text;
        button.disabled = isDisabled;
        button.style.cursor = isDisabled ? 'wait' : '';
    },

    // Create or get response element
    createResponseElement(form) {
        let responseEl = form.querySelector('.form_responseEl');
        if (!responseEl) {
            responseEl = document.createElement('div');
            responseEl.classList.add('form_responseEl');
            form.appendChild(responseEl);
        }
        return responseEl;
    },

    // Handle successful submission
    handleSuccess(form, responseEl) {
        responseEl.innerHTML = '<span class="form-success">با موفقیت انجام شد</span>';

        this.showAlert('فرم با موفقیت ثبت شد', 'success');
        form.reset();
        const formBox = form.closest('.form-box');

        if (formBox) formBox.innerHTML = this.getSuccessSchema();

    },

    // Handle errors
    handleError(form, responseEl, error) {
        if (error.response?.status === 422) {
            const messages = error.response.data.messages;
            this.highlightInvalidFields(form, messages);
            this.displayValidationErrors(responseEl, messages);
            this.showAlert(this.MESSAGES.validationError, 'warning');
        } else {
            responseEl.innerHTML = '<span class="form-error">در فرآیند ثبت درخواست شما مشکلی به‌وجود آمده‌است، لطفا بعدا تلاش کنید</span>';
            this.showAlert(this.MESSAGES.serverError, 'error');
        }
    },

    // Highlight invalid fields
    highlightInvalidFields(form, messages) {
        form.querySelectorAll('.border-red-600').forEach(input =>
            input.classList.remove('input_validation-error')
        );

        Object.keys(messages).forEach(key => {
            const input = form.querySelector(`[name="${key}"]`);
            if (input) input.classList.add('input_validation-error');
        });
    },

    // Display validation errors
    displayValidationErrors(responseEl, messages) {
        const errorList = Object.entries(messages)
            .map(([_, message]) => `<li>${message}</li>`)
            .join('');
        responseEl.innerHTML = `<ul class="form-error-list">${errorList}</ul>`;
    },

    // Show alert (stub - implement based on your alert system)
    showAlert(message, type) {
        responseAlert(message, type);
    },

    // Get success schema HTML
    getSuccessSchema() {
        return `
            <div class="form-success-container">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="form-success-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="form-success-text">${this.MESSAGES.successSchema}</span>
            </div>`;
    }
};

// Load More //
class LoadMore {
    buttons;
    offsets;

    constructor() {
        this.buttons = document.querySelectorAll('.load_more');
        this.offsets = new Map();
        this.init();
    }

    init() {
        this.buttons.forEach((btn, index) => {
            this.offsets.set(btn, 1);
            btn.addEventListener('click', this.handleClick.bind(this), {once: false});
        });
    }

    async handleClick(event) {
        event.preventDefault();
        const btn = event.currentTarget;

        // Validate attributes
        const attributes = this.getButtonAttributes(btn);
        if (!this.validateAttributes(attributes)) {
            console.error('Missing required button attributes');
            return;
        }

        const {classModel, identify, destination, parentIdBox} = attributes;
        const parentList = document.querySelector(`#${parentIdBox}`);

        if (!parentList) {
            console.error(`Parent element #${parentIdBox} not found`);
            return;
        }

        try {
            const response = await this.fetchData(destination, this.offsets.get(btn), classModel, identify);
            this.handleResponse(response, parentList, btn);
        } catch (error) {
            console.error('Failed to load more content:', error);
            responseAlert('something goes wrong', 'error')
        }
    }

    getButtonAttributes(btn) {
        return {
            classModel: btn.dataset.bind,
            identify: btn.dataset.identify,
            destination: btn.dataset.destination,
            parentIdBox: btn.dataset.target
        };
    }

    validateAttributes(attributes) {
        return Object.values(attributes).every(value => value !== undefined && value !== null);
    }

    async fetchData(destination, offset, classModel, identify) {
        const url = new URL(destination);
        url.searchParams.append('offset', offset);
        url.searchParams.append('bind', classModel);
        url.searchParams.append('identify', identify);

        const response = await axios.get(url.toString());
        return response.data.data;
    }

    handleResponse(data, parentList, btn) {
        if (data?.length) {
            parentList.insertAdjacentHTML('beforeend', data);
            this.offsets.set(btn, this.offsets.get(btn) + 1);
        } else {
            btn.remove();
        }
    }
}

// recaptcha //
class RecaptchaHandler {
    static #SELECTORS = {
        BUTTON: '.reload-captcha-btn',
        ICON: '#recaptchaReloadIcon'
    };

    static #CLASSES = {
        SPIN: 'animate-spin'
    };

    static API_ENDPOINT = '/ajax/client-submitting/captcha/load';

    constructor() {
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        document.querySelectorAll(this.constructor.#SELECTORS.BUTTON)
            .forEach(button => {
                button.addEventListener('click', this.handleClick.bind(this));
            });
    }

    async handleClick(event) {
        event.preventDefault();
        const button = event.currentTarget;
        const icon = button.querySelector(this.constructor.#SELECTORS.ICON);
        const targetId = button.dataset.target;
        const image = document.getElementById(targetId);

        if (!image) return;

        button.disabled = true;
        icon?.classList.add(this.constructor.#CLASSES.SPIN);

        try {
            image.src = await this.fetchNewCaptcha();
        } catch (error) {
            console.error('Failed to reload captcha:', error);
        } finally {
            button.disabled = false;
            icon?.classList.remove(this.constructor.#CLASSES.SPIN);
        }
    }

    async fetchNewCaptcha() {
        const response = await axios.get(this.constructor.API_ENDPOINT, {
            headers: {'Content-Type': 'application/json'}
        });
        return response.data.data;
    }
}

class GadgetLoader {
    #cache = new Map();
    #endpoint = '/ajax/client-submitting/gadget';
    #maxRetries = 2;

    constructor(config = {}) {
        this.gadgets = [];
        this.endpoint = config.endpoint || this.#endpoint;
        this.maxRetries = config.maxRetries || this.#maxRetries;
    }

    async init() {
        // Select custom gadget elements
        this.gadgets = document.querySelectorAll('gadget');
        if (!this.gadgets.length) return;

        // Create a document fragment to minimize DOM reflows
        const fragment = document.createDocumentFragment();

        // Batch prepare data for all gadgets
        const dataPromises = Array.from(this.gadgets).map(gadget =>
            this.#prepareData(gadget)
        );

        try {
            // Send batched requests
            const responses = await Promise.all(
                dataPromises.map(data => this.#sendWithRetry(data))
            );

            // Process responses and update DOM
            responses.forEach(({ gadget, response }, index) => {
                if (response?.data?.data) {
                    this.#load(gadget, response.data.data, fragment);
                }
            });

            // Append all changes at once
            document.body.appendChild(fragment);
        } catch (error) {
            console.error('Failed to load gadgets:', error);
        }
    }

    #prepareData(gadget) {
        const attrs = Object.fromEntries(
            Array.from(gadget.attributes).map(attr => [attr.name, attr.value])
        );
        return {
            gadget,
            data: {
                attributes: attrs,
                innerContent: gadget.innerHTML
            }
        };
    }

    async #sendWithRetry(payload, attempt = 1) {
        try {
            // Check cache
            const cacheKey = JSON.stringify(payload.data);
            if (this.#cache.has(cacheKey)) {
                return { ...payload, response: this.#cache.get(cacheKey) };
            }

            // Send request
            const response = await axios.post(this.endpoint, payload.data, {
                timeout: 5000
            });

            // Cache response
            this.#cache.set(cacheKey, response);
            return { ...payload, response };
        } catch (error) {
            if (attempt < this.#maxRetries) {
                return this.#sendWithRetry(payload, attempt + 1);
            }
            console.warn(`Failed to fetch gadget data after ${attempt} attempts:`, error);
            return { ...payload, response: null };
        }
    }

    #load(gadget, data, fragment) {
        try {
            // Create new element and set content
            const newElement = document.createElement('div');
            newElement.innerHTML = data; // Assuming data is HTML string

            // Replace gadget with new content
            const parent = gadget.parentNode;
            if (parent) {
                fragment.appendChild(newElement);
                parent.replaceChild(newElement, gadget);
            }
        } catch (error) {
            console.error('Failed to load gadget:', error);
        }
    }

    cleanup() {
        this.gadgets = [];
        this.#cache.clear();
    }
}
 const loader = new GadgetLoader({ endpoint: '/ajax/client-submitting/gadget', maxRetries: 3 });
 await loader.init();
 loader.cleanup();

document.addEventListener("DOMContentLoaded", function (event) {
    CommentReplyHandler.init();
    FormHandler.init();
    new LoadMore();
    new RecaptchaHandler();
    iconSetter();
});
