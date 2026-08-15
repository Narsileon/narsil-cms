import { Toast as ToastPrimitive } from "@base-ui/react/toast";
import { type GlobalProps } from "@narsil-cms/hooks/use-props";
import { AlertDialogProvider } from "@narsil-ui/blocks/alert-dialog";
import { Head } from "@narsil-ui/blocks/head";
import { TranslatorProvider } from "@narsil-ui/components/translator";
import { useColorStore } from "@narsil-ui/stores/color-store";
import { useRadiusStore } from "@narsil-ui/stores/radius-store";
import { useThemeStore } from "@narsil-ui/stores/theme-store";
import { useEffect, type ReactNode } from "react";

type LiveEditorShellProps = {
  children: ReactNode & {
    props: GlobalProps;
  };
};

/**
 * Same providers as the admin layout, without the sidebar and header chrome:
 * the editor owns the whole viewport.
 */
function LiveEditorShell({ children }: LiveEditorShellProps) {
  const { description, session, title, translations } = children?.props;

  const colorStore = useColorStore();
  const radiusStore = useRadiusStore();
  const themeStore = useThemeStore();

  useEffect(() => {
    colorStore.applyColor();
    radiusStore.applyRadius();
    themeStore.applyTheme();
  }, []);

  useEffect(() => {
    const previousOverflow = document.body.style.overflow;

    document.body.style.overflow = "hidden";

    return () => {
      document.body.style.overflow = previousOverflow;
    };
  }, []);

  return (
    <ToastPrimitive.Provider>
      <TranslatorProvider locale={session.locale} translations={translations}>
        <AlertDialogProvider>
          <Head
            description={description}
            follow={false}
            index={false}
            title={title}
          />
          {children}
        </AlertDialogProvider>
      </TranslatorProvider>
    </ToastPrimitive.Provider>
  );
}

export default LiveEditorShell;
