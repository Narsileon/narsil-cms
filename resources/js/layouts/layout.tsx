import { Toast as ToastPrimitive } from "@base-ui/react/toast";
import { Head } from "@narsil-cms/blocks/head";
import { type GlobalProps } from "@narsil-cms/hooks/use-props";
import { useColorStore } from "@narsil-cms/stores/color-store";
import { useRadiusStore } from "@narsil-cms/stores/radius-store";
import { useThemeStore } from "@narsil-cms/stores/theme-store";
import { Toast } from "@narsil-ui/components/toast";
import { TranslatorProvider } from "@narsil-ui/components/translator";
import { isEmpty } from "lodash-es";
import { type ReactNode, useEffect } from "react";
import AuthLayout from "./auth-layout";
import GuestLayout from "./guest-layout";

type LayoutProps = {
  children: ReactNode & {
    props: GlobalProps;
  };
};

function Layout({ children }: LayoutProps) {
  const { auth, description, redirect, session, translations, title } = children?.props;

  const colorStore = useColorStore();
  const radiusStore = useRadiusStore();
  const themeStore = useThemeStore();

  const { error, info, success, warning } = redirect;

  useEffect(() => {
    colorStore.applyColor();
    radiusStore.applyRadius();
    themeStore.applyTheme();
  }, []);

  return (
    <ToastPrimitive.Provider>
      <TranslatorProvider locale={session.locale} translations={translations}>
        <Head description={description} follow={false} index={false} title={title} />
        {window.location.pathname === "/narsil/graphiql" ? (
          <main className="h-screen w-screen">{children}</main>
        ) : isEmpty(auth) || window.location.pathname.includes("/email/verify") ? (
          <GuestLayout>{children}</GuestLayout>
        ) : (
          <AuthLayout>{children}</AuthLayout>
        )}
        <Toast
          options={[
            ...(error ? [{ description: error, type: "error" }] : []),
            ...(info ? [{ description: info, type: "info" }] : []),
            ...(success ? [{ description: success, type: "success" }] : []),
            ...(warning ? [{ description: warning, type: "warning" }] : []),
          ]}
        />
      </TranslatorProvider>
    </ToastPrimitive.Provider>
  );
}

export default Layout;
