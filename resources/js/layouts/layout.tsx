import { Head } from "@narsil-cms/blocks/head";
import { LocalizationProvider } from "@narsil-cms/components/localization";
import { type GlobalProps } from "@narsil-cms/hooks/use-props";
import { useColorStore } from "@narsil-cms/stores/color-store";
import { useRadiusStore } from "@narsil-cms/stores/radius-store";
import { useThemeStore } from "@narsil-cms/stores/theme-store";
import { isEmpty } from "lodash-es";
import { type ReactNode, useEffect } from "react";
import { toast } from "sonner";
import AuthLayout from "./auth-layout";
import GuestLayout from "./guest-layout";

type LayoutProps = {
  children: ReactNode & {
    props: GlobalProps;
  };
};

function Layout({ children }: LayoutProps) {
  const { auth, description, redirect, translations, title } = children?.props;

  const colorStore = useColorStore();
  const radiusStore = useRadiusStore();
  const themeStore = useThemeStore();

  const { error, info, success, warning } = redirect;

  useEffect(() => {
    colorStore.applyColor();
    radiusStore.applyRadius();
    themeStore.applyTheme();
  }, []);

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
  }, [error, info, success, warning]);

  return (
    <LocalizationProvider translations={translations}>
      <Head description={description} follow={false} index={false} title={title} />
      {window.location.pathname === "/narsil/graphiql" ? (
        <main className="h-screen w-screen">{children}</main>
      ) : isEmpty(auth) ? (
        <GuestLayout>{children}</GuestLayout>
      ) : (
        <AuthLayout>{children}</AuthLayout>
      )}
    </LocalizationProvider>
  );
}

export default Layout;
