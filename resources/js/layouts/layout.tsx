import { router, usePage } from "@inertiajs/react";
import { toast } from "sonner";
import { useEffect } from "react";
import AuthLayout from "./auth-layout";
import GuestLayout from "./guest-layout";
import useTranslationsStore from "@/stores/translations-store";
import type { GlobalProps } from "@/types/global";
import useThemeStore from "@/stores/theme-store";

type LayoutProps = {
  children: React.ReactNode;
};

function Layout({ children }: LayoutProps) {
  const themeStore = useThemeStore();
  const translationStore = useTranslationsStore();

  const { auth, redirect, shared } = usePage<GlobalProps>().props;

  const { error, success } = redirect ?? {};
  const { locale, locales, translations } = shared ?? {};

  useEffect(() => {
    translationStore.setLocale(locale);
    translationStore.setLocales(locales);
    translationStore.setTranslations(translations);
  }, [locale, locales, translations]);

  useEffect(() => {
    const root = window.document.documentElement;

    root.classList.remove("light", "dark");

    if (themeStore.theme === "system") {
      const systemTheme = window.matchMedia("(prefers-color-scheme: dark)")
        .matches
        ? "dark"
        : "light";

      root.classList.add(systemTheme);

      return;
    }

    root.classList.add(themeStore.theme);
  }, [themeStore.theme]);

  useEffect(() => {
    if (success) {
      toast.success(success);
      router.reload({
        only: ["redirect"],
      });
    } else if (error) {
      toast.error(error);
      router.reload({
        only: ["redirect"],
      });
    }
  }, [success, error]);

  return auth ? (
    <AuthLayout>{children}</AuthLayout>
  ) : (
    <GuestLayout>{children}</GuestLayout>
  );
}

export default Layout;
