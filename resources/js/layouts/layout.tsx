import { isEmpty } from "lodash";
import { LabelsProvider } from "@narsil-cms/components/ui/labels";
import { router } from "@inertiajs/react";
import { toast } from "sonner";
import { useAuth, useLabels, useRedirect } from "@narsil-cms/hooks/use-props";
import { useEffect } from "react";
import AuthLayout from "./auth-layout";
import GuestLayout from "./guest-layout";
import useColorStore from "@narsil-cms/stores/color-store";
import useRadiusStore from "@narsil-cms/stores/radius-store";
import useThemeStore from "@narsil-cms/stores/theme-store";

type LayoutProps = {
  children: React.ReactNode;
};

function Layout({ children }: LayoutProps) {
  const colorStore = useColorStore();
  const radiusStore = useRadiusStore();
  const themeStore = useThemeStore();

  colorStore.applyColor();
  radiusStore.applyRadius();
  themeStore.applyTheme();

  const auth = useAuth();
  const labels = useLabels();

  const { error, info, success, warning } = useRedirect();

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
      {isEmpty(auth) ? (
        <GuestLayout>{children}</GuestLayout>
      ) : (
        <AuthLayout>{children}</AuthLayout>
      )}
    </LabelsProvider>
  );
}

export default Layout;
