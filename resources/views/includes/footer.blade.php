<footer>
    <style>
        /* ============================================
   FOOTER STYLES
   ============================================ */

        .f_info_links,
        .f_info_socials,
        .f_info_brand {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .f_info_socials a {
            color: #212529;
            /* neutral default color */
            transition: color 0.3s ease, transform 0.2s ease;
        }


        .f_info_socials a i {
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        .f_info_socials a:hover {
            color: #fe424d;
        }

        .f_info {
            text-align: center;
            background-color: #ebebeb;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            gap: 0.3rem;
            padding: 0.5rem 0;
        }

        .f_info_links a {
            text-decoration: none;
            color: #222222;
        }

        .f_info_links a:hover {
            text-decoration: underline;
        }

        .f_info_developer {
            text-align: center;
            margin-top: 1rem;
            color: #666;
            font-size: 0.95rem;
            /* background-color: yellow; */
        }

        .f_info_developer a {
            color: #333;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .f_info_developer a:hover {
            color: #fe424d;
        }

        /* ============================================
   RESPONSIVE STYLES - Footer
   ============================================ */

        /* Tablets and medium screens */
        @media (max-width: 992px) {
            .f_info_socials a i {
                font-size: 1.25rem;
                margin-right: 0.75rem;
            }
        }

        /* Small tablets and large phones */
        @media (max-width: 768px) {
            .f_info {
                padding: 1rem 0.5rem;
                gap: 0.5rem;
            }

            .f_info_links {
                flex-direction: column;
                gap: 0.5rem;
            }

            .f_info_socials a i {
                font-size: 1rem;
                margin-right: 0.5rem;
            }
        }

        /* Mobile phones */
        @media (max-width: 576px) {
            .f_info {
                padding: 0.75rem 0.25rem;
                gap: 0.25rem;
            }

            .f_info_links a {
                font-size: 0.85rem;
            }

            .f_info_socials a i {
                font-size: 1rem;
                margin-right: 0.25rem;
            }

            .f_info_brand {
                font-size: 0.85rem;
            }
        }

        /* Very small screens */
        @media (max-width: 400px) {
            .f_info_links a {
                font-size: 0.75rem;
            }

            .f_info_socials a i {
                font-size: 1rem;
            }
        }
    </style>
    <div class="f_info">
        <div class="f_info_socials">
            <a href="https://www.instagram.com/niloybe" target="_blank"><i class="fa-brands fa-square-instagram"></i></a>
            <a href="https://www.linkedin.com/in/yourprofile" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
            <a href="https://github.com/niloy2107028" target="_blank"><i class="fa-brands fa-square-github"></i></a>
            <a href="https://facebook.com/yourprofile" target="_blank"><i class="fa-brands fa-square-facebook"></i></a>
        </div>

        <div class="f_info_brand">&copy; Airnbn Private Limited</div>

        <div class="f_info_links">
            <a href="/privacy">Privacy</a>
            <a href="/terms">Terms</a>
        </div>

        <div class="f_info_developer">
            Built with ❤️ by
            <a href="https://github.com/niloy2107028" target="_blank">Shoaib Hasan Niloy</a>
        </div>
    </div>
</footer>
