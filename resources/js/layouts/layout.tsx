import { isEmpty } from "lodash";
import { router, usePage } from "@inertiajs/react";
import { toast } from "sonner";
import { useEffect } from "react";
import AuthLayout from "./auth-layout";
import GuestLayout from "./guest-layout";
import useColorStore from "@/stores/color-store";
import useRadiusStore from "@/stores/radius-store";
import useThemeStore from "@/stores/theme-store";
import useTranslationsStore from "@/stores/translations-store";
import type { GlobalProps } from "@/types/global";

type LayoutProps = {
  children: React.ReactNode;
};

function Layout({ children }: LayoutProps) {
  const translationStore = useTranslationsStore();

  const colorStore = useColorStore();
  const radiusStore = useRadiusStore();
  const themeStore = useThemeStore();

  colorStore.applyColor();
  radiusStore.applyRadius();
  themeStore.applyTheme();

  const { auth, redirect, shared } = usePage<GlobalProps>().props;

  const { locale, locales, translations } = shared ?? {};

  useEffect(() => {
    translationStore.setLocale(locale);
    translationStore.setLocales(locales);
    translationStore.setTranslations(translations);
  }, [locale, locales, translations]);

  const { error, info, success, warning } = redirect ?? {};

  useEffect(() => {
    if (error) {
      toast.error(error);
    } else if (info) {
      toast.info(info);
    } else if (success) {
      toast.success(success);
    } else if (warning) {
      toast.warning(warning);
    }

    router.reload({
      only: ["redirect"],
    });
  }, [error, info, success, warning]);

  return isEmpty(auth) ? (
    <GuestLayout>{children}</GuestLayout>
  ) : (
    <AuthLayout>{children}</AuthLayout>
  );
}

export default Layout;
