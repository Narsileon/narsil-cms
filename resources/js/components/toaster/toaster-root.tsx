import { Toaster } from "sonner";

import { cn } from "@narsil-cms/lib/utils";
import useThemeStore from "@narsil-cms/stores/theme-store";

type ToasterRootProps = React.ComponentProps<typeof Toaster> & {};

function ToasterRoot({ ...props }: ToasterRootProps) {
  const { theme } = useThemeStore();

  return (
    <Toaster
      data-slot="toaster-root"
      className="toaster group"
      theme={theme}
      toastOptions={{
        classNames: {
          toast: "group",
          icon: cn(
            "group-data-[type=error]:text-red-500",
            "group-data-[type=info]:text-blue-500",
            "group-data-[type=success]:text-green-500",
            "group-data-[type=warning]:text-amber-500",
          ),
        },
      }}
      style={
        {
          "--normal-bg": "var(--popover)",
          "--normal-text": "var(--popover-foreground)",
          "--normal-border": "var(--border)",
        } as React.CSSProperties
      }
      {...props}
    />
  );
}

export default ToasterRoot;
