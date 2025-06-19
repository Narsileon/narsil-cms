import { Toaster as Sonner } from "sonner";
import { useTheme } from "next-themes";

export type ToasterProps = React.ComponentProps<typeof Sonner> & {
  theme?: "light" | "dark" | "system";
};

function Toaster({ ...props }: ToasterProps) {
  const { theme = "system" } = useTheme();

  return (
    <Sonner
      className="toaster group"
      theme={theme as ToasterProps["theme"]}
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
