import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";

type SpinnerProps = Omit<React.ComponentProps<typeof Icon>, "name"> & {};

function Spinner({ className, ...props }: SpinnerProps) {
  return (
    <Icon
      data-slot="spinner"
      className={cn("animate-spin", className)}
      name="loader-circle"
      {...props}
    />
  );
}

export default Spinner;
