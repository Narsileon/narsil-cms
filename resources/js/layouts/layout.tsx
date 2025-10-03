import { router } from "@inertiajs/react";
import { isEmpty } from "lodash";
import { useEffect } from "react";
import { toast } from "sonner";

import { Head } from "@narsil-cms/blocks";
import { LocalizationProvider } from "@narsil-cms/components/localization";
import { type GlobalProps } from "@narsil-cms/hooks/use-props";
import { useColorStore } from "@narsil-cms/stores/color-store";
import { useRadiusStore } from "@narsil-cms/stores/radius-store";
import { useThemeStore } from "@narsil-cms/stores/theme-store";

import AuthLayout from "./auth-layout";
import GuestLayout from "./guest-layout";

type LayoutProps = {
  children: React.ReactNode & {
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

    router.reload({
      only: ["redirect"],
    });
  }, [error, info, success, warning]);

  return (
    <LocalizationProvider translations={translations}>
      <Head
        description={description}
        follow={false}
        index={false}
        title={title}
      />
      {isEmpty(auth) ? (
        <GuestLayout>{children}</GuestLayout>
      ) : (
        <AuthLayout>{children}</AuthLayout>
      )}
    </LocalizationProvider>
  );
}

export default Layout;
