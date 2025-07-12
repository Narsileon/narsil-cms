import { Toaster as Sonner } from "sonner";
import useThemeStore from "@/stores/theme-store";
import type { Theme } from "@/stores/theme-store";

type ToasterProps = React.ComponentProps<typeof Sonner> & {
  theme?: Theme;
};

function Toaster({ ...props }: ToasterProps) {
  const { theme } = useThemeStore();

  return (
    <Sonner
      className="toaster group"
      theme={theme}
      toastOptions={{
        classNames: {
          toast: "group",
          icon: "group-data-[type=error]:text-red-500 group-data-[type=success]:text-green-500 group-data-[type=warning]:text-amber-500 group-data-[type=info]:text-blue-500",
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

export default Toaster;
