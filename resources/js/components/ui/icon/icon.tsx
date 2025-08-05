import * as React from "react";
import { getIcon, IconName } from "@narsil-cms/plugins/icons";
import { cn } from "@narsil-cms/lib/utils";

type IconProps = React.ComponentProps<"svg"> & {
  name: IconName;
};

function Icon({ className, name, ...props }: IconProps) {
  const DynamicIcon = getIcon(name);

  return <DynamicIcon className={cn("size-5", className)} {...props} />;
}

export default Icon;
