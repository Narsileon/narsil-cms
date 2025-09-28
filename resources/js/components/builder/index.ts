import type { Block } from "@narsil-cms/types";

import Builder from "./builder";
import BuilderAdd from "./builder-add";
import BuilderItem from "./builder-item";

export type BuilderNode = {
  block: Block;
  block_id: number;
  children: BuilderNode[];
  entity_uuid: string;
  id: number | string;
  parent_id: number | null;
  position: number;
  values: Record<string, unknown>;
};

export { Builder, BuilderAdd, BuilderItem };
