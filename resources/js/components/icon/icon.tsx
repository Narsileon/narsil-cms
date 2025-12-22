import { cn } from "@narsil-cms/lib/utils";
import { getIcon, IconName } from "@narsil-cms/plugins/icons";
import { startCase } from "lodash-es";
import { type ComponentProps } from "react";

type IconProps = ComponentProps<"svg"> & {
  name: IconName;
};

function Icon({ className, name, ...props }: IconProps) {
  const Comp = getIcon(name);

  return (
    <Comp
      data-slot="icon"
      className={cn("size-5 text-primary", className)}
      aria-label={startCase(name)}
      {...props}
    />
  );
}

export default Icon;
