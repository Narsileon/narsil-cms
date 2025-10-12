import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type SpinnerRootProps = Omit<ComponentProps<typeof Icon>, "name">;

function SpinnerRoot({ className, ...props }: SpinnerRootProps) {
  return (
    <Icon
      data-slot="spinner-root"
      className={cn("animate-spin", className)}
      name="loader-circle"
      role="status"
      {...props}
    />
  );
}

export default SpinnerRoot;
