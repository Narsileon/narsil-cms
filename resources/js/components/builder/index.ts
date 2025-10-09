import type { Block } from "@narsil-cms/types";

import Builder from "./builder";
import BuilderAdd from "./builder-add";
import BuilderItem from "./builder-item";

export type BuilderNode = {
  block_id: number;
  block: Block;
  children: BuilderNode[];
  entity_uuid: string;
  parent_id: number | null;
  position: number;
  uuid: string;
  values: Record<string, unknown>;
};

export { Builder, BuilderAdd, BuilderItem };
