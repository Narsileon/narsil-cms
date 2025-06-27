import { router, usePage } from "@inertiajs/react";
import { toast } from "sonner";
import { useEffect } from "react";
import { useTranslationsStore } from "@/stores/translations-store";
import type { GlobalProps } from "@/types/global";
import AuthLayout from "./auth-layout";
import GuestLayout from "./guest-layout";

type LayoutProps = {
  children: React.ReactNode;
};

function Layout({ children }: LayoutProps) {
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
