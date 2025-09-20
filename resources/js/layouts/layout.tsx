import { router } from "@inertiajs/react";
import { isEmpty } from "lodash";
import { useEffect } from "react";
import { toast } from "sonner";

import { Head } from "@narsil-cms/blocks";
import { LabelsProvider } from "@narsil-cms/components/labels";
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
  const { auth, description, labels, redirect, title } = children?.props;

  const colorStore = useColorStore();
  const radiusStore = useRadiusStore();
  const themeStore = useThemeStore();

  colorStore.applyColor();
  radiusStore.applyRadius();
  themeStore.applyTheme();

  const { error, info, success, warning } = redirect;

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
    <LabelsProvider labels={labels}>
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
    </LabelsProvider>
  );
}

export default Layout;
